<?php

namespace App\Helpers;

use App\Models\Video;
use Illuminate\Support\Collection;

class VideoHelper {

    public static function create_default_video(int $userId): Collection
    {
        $existingVideos = Video::all();
        if ($existingVideos->isNotEmpty()) {
            return $existingVideos;
        }

        $video1 = Video::create([
            'title' => 'Ipswich Town 1-4 Tottenham Hotspur',
            'description' => 'Ipswich Town 1-4 Tottenham Hotspur | Premier League Extended Highlights!',
            'url' => 'https://www.youtube.com/embed/eARBVZWOaZM?si=qc-FpsQeGCDtezuP',
            'published_at' => now(),
            'previous_id' => null,
            'next_id' => null,
            'series_id' => null,
            'is_default' => true,
            'user_id' => $userId, // Add this
        ]);

        $video2 = Video::create([
            'title' => 'Man City 0-4 Tottenham Hotspur',
            'description' => 'Man City 0-4 Tottenham Hotspur | Extended Premier League Highlights | Spurs run riot in Manchester',
            'url' => 'https://www.youtube.com/embed/nK6DQcHrP8Y?si=FNVZwdWKavmIVAv1',
            'published_at' => now(),
            'previous_id' => null,
            'next_id' => null,
            'series_id' => null,
            'is_default' => true,
            'user_id' => $userId, // Add this
        ]);

        $video3 = Video::create([
            'title' => 'Man United 0-3 Tottenham Hotspur',
            'description' => 'Spurs run riot in Manchester // Man United 0-3 Tottenham Hotspur // EXTENDED EPL HIGHLIGHTS.',
            'url' => 'https://www.youtube.com/embed/Ye-obwA0Ejo?si=Z5GNRvxDvb1DXfud',
            'published_at' => now(),
            'previous_id' => null,
            'next_id' => null,
            'series_id' => null,
            'is_default' => true,
            'user_id' => $userId, // Add this
        ]);

        $video1->update(['next_id' => $video2->id]);
        $video2->update(['previous_id' => $video1->id, 'next_id' => $video3->id]);
        $video3->update(['previous_id' => $video2->id]);

        return collect([$video1, $video2, $video3]);
    }
}