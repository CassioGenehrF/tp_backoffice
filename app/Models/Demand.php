<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    protected $table = 'backoffice_demands';

    protected $fillable = [
        'id',
        'checkin',
        'checkout',
        'client',
        'phone',
        'price',
        'people_number',
        'type'
    ];

    public static function new(array $data, $callback)
    {
        if (
            Carbon::createFromFormat('Y-m-d', $data['checkin']) >
            Carbon::createFromFormat('Y-m-d', $data['checkout'])
        ) {
            return back()->withErrors('Data de Check-in deve ser menor do que Check-out.');
        }

        $demand = Demand::create([
            'checkin' => $data['checkin'],
            'checkout' => $data['checkout'],
            'client' => $data['client'],
            'phone' => $data['phone'],
            'price' => $data['price'],
            'people_number' => $data['people_number'],
            'type' => $data['type']
        ]);

        return $callback;
    }
}
