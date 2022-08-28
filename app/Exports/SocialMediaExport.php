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

        foreach ($days as $key => $day) {
            $data[0][$key] = $properties[rand(0, count($properties) - 1)];
            $data[1][$key] = $properties[rand(0, count($properties) - 1)];
            $data[2][$key] = $properties[rand(0, count($properties) - 1)];
            $data[3][$key] = $properties[rand(0, count($properties) - 1)];
            $data[4][$key] = $properties[rand(0, count($properties) - 1)];
        }

        return view('admin.social_media.table', [
            'properties' => $data,
            'days' => $days
        ]);
    }
}
