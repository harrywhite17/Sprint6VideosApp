<?php

// tests/Unit/VideoTest.php

namespace Tests\Unit;

use App\Models\Video;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_formatted_published_at_date()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create([
            'title' => 'Fugit quam consequatur mollitia sed quibusdam est inventore.',
            'url' => 'http://example.com/video3',
            'is_default' => false,
            'published_at' => '2023-05-15 12:00:00',
            'user_id' => $user->id,
        ]);
        $this->assertEquals('15 de May de 2023', $video->formatted_published_at);
    }

    public function test_can_get_formatted_published_at_date_when_not_published()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create([
            'title' => 'Sunt ipsam labore ipsam.',
            'url' => 'http://example.com/video4',
            'is_default' => false,
            'published_at' => null,
            'user_id' => $user->id,
        ]);
        $this->assertNull($video->formatted_published_at);
    }

    public function testCanGetFormattedVideo()
    {
        $user = User::factory()->create();
        $video = Video::create([
            'title' => 'Adipisci magnam numquam nesciunt quo repellat.',
            'url' => 'http://example.com/video5',
            'is_default' => false,
            'published_at' => '2023-05-15 12:00:00',
            'user_id' => $user->id,
        ]);
        $this->assertEquals('Adipisci magnam numquam nesciunt quo repellat.', $video->title);
    }

    public function testAnotherVideoTest()
    {
        $user = User::factory()->create();
        $video = Video::create([
            'title' => 'Est beatae laudantium ea totam maxime.',
            'url' => 'http://example.com/video6',
            'is_default' => false,
            'published_at' => now(),
            'user_id' => $user->id,
        ]);
        $this->assertEquals('Est beatae laudantium ea totam maxime.', $video->title);
    }
}