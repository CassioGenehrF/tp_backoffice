<?php

namespace App\Helpers;

use App\Models\RentalInformation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportBuilder
{
    public static function report($user_id, $propertyId = 0, $isBroker = false)
    {
        $reservations = RentalInformation::reportPropertyInformations($user_id, $propertyId);

        $year = now()->year;

        for ($i = 0; $i < 12; $i++) {
            $index = $i + 1;

            if ($index < 10) {
                $index = "0$index";
            }

            $report["$index/$year"]['reservations'] = 0;
            $report["$index/$year"]['daily'] = 0;
            $report["$index/$year"]['total'] = 0;

            if (!$isBroker) {
                $report["$index/$year"]['tax'] = 0;
            }

            if (!$propertyId || $isBroker) {
                $report["$index/$year"]['comission'] = 0;
            }
        }

        foreach ($reservations as $reservation) {
            $month = Carbon::createFromFormat('Y-m-d', $reservation->checkin)->format('m');

            $report["$month/$year"]['reservations'] += 1;
            $report["$month/$year"]['daily'] += Carbon::createFromFormat('Y-m-d', $reservation->commitment->checkout)->diffInDays(Carbon::createFromFormat('Y-m-d', $reservation->checkin));

            if (!$isBroker) {
                $report["$month/$year"]['total'] += ($reservation->price * 90 / 100);
                $report["$month/$year"]['tax'] += ($reservation->price * 10 / 100);
            } else {
                $report["$month/$year"]['total'] += $reservation->price;
            }

            if ($isBroker) {
                $comission = $user_id == $reservation->user_indication_id ? $reservation->publisher_tax : 0;
                $comission += $user_id == $reservation->user_id ? $reservation->broker_tax : 0;
                $report["$month/$year"]['comission'] += $comission;
            } else if (!$propertyId) {
                $report["$month/$year"]['comission'] += $reservation->publisher_tax;
            }
        }

        if (Auth::user()->role == 'administrator') {
            $site_tax = RentalInformation::select('site_tax', 'commitment_id')->with('commitment')->get();
            foreach ($site_tax as $tax) {
                $month = Carbon::createFromFormat('Y-m-d', $tax->commitment->checkin)->format('m');
                $report["$month/$year"]['comission'] += $tax->site_tax;
            }
        }

        $reportHTML = self::printReport($report, $propertyId, $isBroker);
        return $reportHTML;
    }

    private static function printReport($report, $propertyId, $isBroker)
    {
        $html = '';
        foreach ($report as $data => $row) {
            $tax = '';
            $comission = '';
            if (!$propertyId) {
                $comission = "<td> " . 'R$ ' . str_replace('.', ',', $row['comission']) . " </td>";
            }

            if (!$isBroker) {
                $tax = "<td> " . 'R$ ' . str_replace('.', ',', $row['tax']) . " </td>";
            }

            $html .= "
                <tr>
                    <td> $data </td>
                    <td> " . $row['reservations'] . " </td>
                    <td> " . $row['daily'] . " </td>
                    <td> " . 'R$ ' . str_replace('.', ',', $row['total']) . " </td>
                    $tax
                    $comission
                </tr>
            ";
        }

        return $html;
    }
}
