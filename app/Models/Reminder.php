<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'backoffice_reminders';

    protected $fillable = [
        'id',
        'checkin',
        'checkout',
        'client',
        'phone',
        'price',
        'people_number',
        'period',
        'property_id'
    ];

    public static function new(array $data, $callback)
    {
        if (
            Carbon::createFromFormat('Y-m-d', $data['checkin']) >
            Carbon::createFromFormat('Y-m-d', $data['checkout'])
        ) {
            return back()->withErrors('Data de Check-in deve ser menor do que Check-out.');
        }

        $reminder = Reminder::create([
            'checkin' => $data['checkin'],
            'checkout' => $data['checkout'],
            'client' => $data['client'],
            'phone' => $data['phone'],
            'price' => $data['price'],
            'people_number' => $data['people_number'],
            'period' => $data['period'],
            'property_id' => $data['property_id']
        ]);

        return $callback;
    }

    public static function getNotifications()
    {
        $reminders = array_merge(
            Reminder::getHolidayNotify()->toArray(),
            Reminder::getWeekendNotify()->toArray()
        );

        if (now()->month == 10) {
            $reminders = array_merge(
                $reminders,
                Reminder::getEndYearNotify()->toArray()
            );
        }

        return $reminders;
    }

    public static function getEndYearNotify()
    {
        $reminders = Reminder::query()
            ->whereRaw("MONTH(checkin) IN (10, 11, 12)")
            ->whereRaw("YEAR(checkin) = YEAR(NOW())")
            ->whereIn("period", ["new_year", "christmas"])
            ->get();

        return $reminders;
    }

    public static function getHolidayNotify()
    {
        $reminders = Reminder::query()
            ->where("period", "holiday")
            ->whereRaw("YEAR(checkin) = YEAR(NOW())")
            ->whereRaw("DATE_SUB(checkin, INTERVAL 3 MONTH)")
            ->get();

        return $reminders;
    }

    public static function getWeekendNotify()
    {
        $reminders = Reminder::query()
            ->where("period", "weekend")
            ->whereRaw("YEAR(checkin) = YEAR(NOW())")
            ->whereRaw("DATE_SUB(checkin, INTERVAL 2 MONTH)")
            ->get();

        return $reminders;
    }
}
