<?php

namespace Tests\Feature\Video;

use Tests\TestCase;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_view_videos()
    {
        $video = Video::factory()->create();

        $response = $this->get(route('videos.show', $video));

        $response->assertStatus(200);
        $response->assertViewIs('videos.show');
        $response->assertViewHas('video', $video);
    }

    /** @test */
    public function users_cannot_view_not_existing_videos()
    {
        $response = $this->get(route('videos.show', 999));

        $response->assertStatus(404);
    }
    public function test_users_can_view_videos()
    {
        $video = Video::factory()->create();
        $response = $this->actingAs(User::factory()->create())->get('/videos/' . $video->id);
        $response->assertStatus(200);
    }
}