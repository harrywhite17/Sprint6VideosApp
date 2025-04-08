<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Series;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SerieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function serie_have_videos()
    {
        // Create a series
        $series = Series::factory()->create();

        // Create a video and associate it with the series
        $video = Video::factory()->create(['series_id' => $series->id]);

        // Assert that the series has videos
        $this->assertTrue($series->videos->contains($video));
    }
}