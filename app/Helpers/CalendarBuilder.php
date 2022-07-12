<?php

namespace App\Helpers;

use App\Models\Commitment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CalendarBuilder
{
    public static function create($propertyId, $monthId = null, $yearId = null)
    {
        $startMonth = now()->startOfMonth();
        $endMonth = now()->endOfMonth();

        if ($monthId && $yearId) {
            $startMonth = (Carbon::createFromDate($yearId, $monthId))->startOfMonth();
            $endMonth = (Carbon::createFromDate($yearId, $monthId))->endOfMonth();
        }

        $weekDay = [
            'Sun' => 0,
            'Mon' => 1,
            'Tue' => 2,
            'Wed' => 3,
            'Thu' => 4,
            'Fri' => 5,
            'Sat' => 6
        ];

        $period = CarbonPeriod::create($startMonth, $endMonth);
        $row = "<tr>";
        foreach ($period->toArray() as $key => $date) {
            if ($key == 0) {
                $dayOfWeek = date('D', $date->timestamp);
                $firstDayMonth = $weekDay[$dayOfWeek];

                for ($j = 0; $j < $firstDayMonth; $j++) {
                    $row .= "<td></td>";
                }
            }

            $class = '';
            if ($key == count($period->toArray()) - 1) {
                $class = "class='last-element'";
            }

            $commitment = self::hasCommitment($propertyId, $date, $startMonth, $endMonth);

            $row .= "
            <td $class data-date='" . $date->format('d/m/Y') . "'>
                <div class='day-field-wrapper'>
                    <div class='day-field'>" . $date->format('d') . "</div>
                </div>
                <div class='events-wrapper'>
                    $commitment
                </div>
            </td>";

            $dayOfWeek = date('D', $date->timestamp);
            if ($weekDay[$dayOfWeek] == 6) {
                $row .= "</tr><tr>";
            }
        }

        $row .= "</tr>";
        return $row;
    }

    private static function hasCommitment($propertyId, $date, $startMonth, $endMonth)
    {
        $commitments = Commitment::between($propertyId, $startMonth, $endMonth);

        foreach ($commitments as $commitment) {
            $initialDate = $startMonth->gte($commitment->checkin) ? $startMonth : new Carbon($commitment->checkin);
            $endDate = $endMonth->lte($commitment->checkout) ? $endMonth : new Carbon($commitment->checkout);

            if ($date->gte($initialDate) && $date->lte($endDate)) {
                $style = $commitment->type == 'blocked' ?
                    "order: 1; background: rgb(253, 216, 222); color: rgb(121, 6, 25);" :
                    "order: 1; background: rgb(199, 245, 217); color: rgb(11, 65, 33);";

                $eventType = $commitment->type == 'blocked' ? 'Bloqueado' : 'Alugado';
                $eventMessage = "<h6><strong>$eventType</strong></h6>
                <p class=`mb-0`>
                    <small>
                        <i class=`fas fa-calendar-alt pr-1`></i>
                        " . $initialDate->format('d/m/Y') . " - " . $endDate->format('d/m/Y') . "
                    </small>
                </p>";

                $title = $initialDate->equalTo($date) ? "$eventType" : "&nbsp;";

                $event = "
                <div 
                    data-mdb-event-key='1'
                    data-mdb-event-order='0'
                    class='event event-1 event-long event-readonly'
                    data-mdb-toggle='tooltip'
                    data-mdb-offset='0,10'
                    data-mdb-html='true'
                    title=''
                    style='$style'
                    data-mdb-original-title='$eventMessage'>
                    $title
                </div>";

                return $event;
            }
        }

        return false;
    }
}
