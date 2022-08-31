<?php

namespace App\Exports;

use App\Models\Property;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SocialMediaExport implements FromView
{
    public function view(): View
    {
        $days = [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
            21, 22, 23, 24, 25, 26, 27, 28, 29, 30
        ];

        $data = [
            0 => [],
            1 => [],
            2 => [],
            3 => [],
            4 => []
        ];

        $properties = Property::export();

        $low = 15;
        $medium = 60;

        while ($medium > 0 || $low > 0) {
            $hour = rand(0, 4);
            $day = rand(0, 29);

            if (!isset($data[$hour][$day])) {
                if ($low > 0) {
                    $data[$hour][$day] = $properties['low'][rand(0, count($properties['low']) - 1)];
                    $low--;
                    continue;
                }

                if ($medium > 0) {
                    $data[$hour][$day] = $properties['medium'][rand(0, count($properties['medium']) - 1)];
                    $medium--;
                    continue;
                }
            }
        }

        foreach ($days as $key => $day) {
            if (!isset($data[0][$day - 1])) {
                $data[0][$day - 1] = $properties['high'][rand(0, count($properties['high']) - 1)];
            }

            if (!isset($data[1][$day - 1])) {
                $data[1][$day - 1] = $properties['high'][rand(0, count($properties['high']) - 1)];
            }

            if (!isset($data[2][$day - 1])) {
                $data[2][$day - 1] = $properties['high'][rand(0, count($properties['high']) - 1)];
            }

            if (!isset($data[3][$day - 1])) {
                $data[3][$day - 1] = $properties['high'][rand(0, count($properties['high']) - 1)];
            }

            if (!isset($data[4][$day - 1])) {
                $data[4][$day - 1] = $properties['high'][rand(0, count($properties['high']) - 1)];
            }
        }

        return view('admin.social_media.table', [
            'properties' => $data,
            'days' => $days
        ]);
    }
}
