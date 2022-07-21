<?php

namespace App\Helpers;

use App\Models\Receipt;
use App\Models\RentalInformation;
use Carbon\Carbon;

class ReportBuilder
{
    public static function report($user_id, $propertyId = 0, $isBroker = false, $isAdmin = false)
    {
        $reservations = RentalInformation::reportPropertyInformations($user_id, $propertyId, $isAdmin);
        $receipts = Receipt::where('user_id', $user_id)
            ->where(function ($query) {
                $query->whereDate('backoffice_receipts.month', '>=', now()->startOfYear());
                $query->whereDate('backoffice_receipts.month', '<=', now()->endOfYear());
            })
            ->get();

        $year = now()->year;

        for ($i = 0; $i < 12; $i++) {
            $index = $i + 1;

            if ($index < 10) {
                $index = "0$index";
            }


            $report["$index/$year"]['receipt']['id'] = 0;
            $report["$index/$year"]['receipt']['value'] = 0;
            $report["$index/$year"]['reservations'] = 0;
            $report["$index/$year"]['daily'] = 0;
            $report["$index/$year"]['total'] = 0;
            $report["$index/$year"]['tax'] = 0;

            if (!$propertyId || $isBroker) {
                $report["$index/$year"]['comission'] = 0;
            }

            if ($isAdmin) {
                $report["$index/$year"]['direct_rent'] = 0;
                $report["$index/$year"]['comission'] = 0;
                $report["$index/$year"]['regional_comission'] = 0;
            }
        }

        if (!$propertyId) {
            foreach ($receipts as $receipt) {
                $month = Carbon::createFromFormat('Y-m-d', $receipt->month)->format('m');
                $report["$month/$year"]['receipt']['id'] = $receipt->id;
                $report["$month/$year"]['receipt']['value'] = $receipt->value;
            }
        }

        foreach ($reservations as $reservation) {
            $month = Carbon::createFromFormat('Y-m-d', $reservation->checkin)->format('m');

            $report["$month/$year"]['reservations'] += 1;
            $report["$month/$year"]['daily'] += Carbon::createFromFormat('Y-m-d', $reservation->commitment->checkout)->diffInDays(Carbon::createFromFormat('Y-m-d', $reservation->checkin));
            $report["$month/$year"]['total'] += $reservation->price;
            $report["$month/$year"]['tax'] += ($reservation->price * 10 / 100);

            if ($isBroker) {
                $comission = $user_id == $reservation->user_indication_id ? $reservation->publisher_tax : 0;
                $comission += $user_id == $reservation->user_id ? $reservation->broker_tax : 0;
                $report["$month/$year"]['comission'] += $comission;
            } else if ($isAdmin) {
                $comission = (($reservation->site_tax + $reservation->regional_tax) == $reservation->price * 10 / 100) ?
                    'direct' : 'comission';

                if ($comission == 'direct') {
                    $report["$month/$year"]['direct_rent'] += $reservation->site_tax;
                } else {
                    $report["$month/$year"]['comission'] += $reservation->site_tax;
                }
            } else if (!$propertyId) {
                $comission = $user_id == $reservation->user_indication_id ? $reservation->publisher_tax : 0;
                $report["$month/$year"]['comission'] += $comission;
            }

            if ($isAdmin) {
                $report["$month/$year"]['regional_comission'] += $reservation->regional_tax;
            }
        }

        $reportHTML = self::printReport($report, $propertyId, $isBroker, $isAdmin);
        return $reportHTML;
    }

    private static function printReport($report, $propertyId, $isBroker, $isAdmin)
    {
        $html = '';

        foreach ($report as $data => $row) {
            $tax = '';
            $comission = '';
            $regional_comission = '';
            $direct_rent = '';
            
            if (!$isBroker) {
                $tax = "<td> " . 'R$ ' . str_replace('.', ',', $row['tax']) . " </td>";
            }

            if (!$propertyId || $isBroker || $isAdmin) {
                $comission = "<td> " . 'R$ ' . str_replace('.', ',', $row['comission']) . " </td>";
            }

            if ($isAdmin) {
                $direct_rent = "<td> " . 'R$ ' . str_replace('.', ',', $row['direct_rent']) . " </td>";
                $regional_comission = "<td> " . 'R$ ' . str_replace('.', ',', $row['regional_comission']) . " </td>";
            }

            $html .= "
                <tr>
                    <td> $data </td>
                    <td> " . $row['reservations'] . " </td>
                    <td> " . $row['daily'] . " </td>
                    <td> " . 'R$ ' . str_replace('.', ',', $row['total']) . " </td>
                    $tax
                    $direct_rent
                    $comission
                    $regional_comission
                </tr>
            ";

            if ($row['receipt']['value'] > 0) {
                $html .= "
                    <tr style='background-color: rgb(0 0 0 / 30%);'>
                        <td>Relatório de Repasses</td>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td> " . 'R$ ' . number_format($row['receipt']['value'], 2, ',', '') . " </td>
                        <td>
                            <a class='text-decoration-none' target='_blank'
                                href='". route('owner.download_receipt', ['id' => $row['receipt']['id']]) ."'>
                                Visualizar
                            </a>
                        </td>
                    </tr>
                ";
            }
        }

        return $html;
    }
}
