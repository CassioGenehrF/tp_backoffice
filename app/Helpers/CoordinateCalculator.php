<?php

namespace App\Helpers;

class CoordinateCalculator
{
    public static function distanceBetween($lat1, $lng1, $lat2, $lng2)
    {
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $lon1 = deg2rad($lng1);
        $lon2 = deg2rad($lng2);

        $dist = (6371 * acos(cos($lat1) * cos($lat2) * cos($lon2 - $lon1) + sin($lat1) * sin($lat2)));
        $dist = number_format($dist, 2, '.', '');
        return $dist;
    }
}
