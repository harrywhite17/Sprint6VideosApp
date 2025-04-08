<?php

namespace App\Helpers;

use App\Models\Series;

class SeriesHelper
{
    public function create_series()
    {
        $seriesData = [
            [
                'title' => 'Series 1',
                'description' => 'Description for Series 1',
                'user_name' => 'User 1',
                'published_at' => now(),
            ],
            [
                'title' => 'Series 2',
                'description' => 'Description for Series 2',
                'user_name' => 'User 2',
                'published_at' => now(),
            ],
            [
                'title' => 'Series 3',
                'description' => 'Description for Series 3',
                'user_name' => 'User 3',
                'published_at' => now(),
            ],
        ];

        foreach ($seriesData as $data) {
            Series::create($data);
        }
    }
}