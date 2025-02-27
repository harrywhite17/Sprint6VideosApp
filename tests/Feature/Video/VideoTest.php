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

    public function test_user_with_permissions_can_manage_videos()
    {
        // Create a user with the necessary permissions
        $user = User::factory()->create();
        $user->givePermissionTo('view videos', 'create videos', 'edit videos', 'delete videos');

        // Create 3 video instances
        $videos = Video::factory()->count(3)->create();

        // Act as the user
        $this->actingAs($user);

        // Visit the manage videos page
        $response = $this->get(route('videos.manage'));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the videos are visible on the page
        foreach ($videos as $video) {
            $response->assertSee($video->title);
            $response->assertSee($video->description);
        }
    }
    public function test_user_without_permissions_can_see_default_videos_page()
    {
        // Create a regular user without special permissions
        $user = User::factory()->create();

        // Act as the user
        $this->actingAs($user);

        // Visit the default videos page
        $response = $this->get(route('videos.index'));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that default videos are visible on the page
        $defaultVideos = Video::where('is_default', true)->get();
        foreach ($defaultVideos as $video) {
            $response->assertSee($video->title);
            $response->assertSee($video->description);
        }
    }

    public function test_user_with_permissions_can_see_default_videos_page()
    {
        // Create a user with the necessary permissions
        $user = User::factory()->create();
        $user->givePermissionTo('view videos');

        // Act as the user
        $this->actingAs($user);

        // Visit the default videos page
        $response = $this->get(route('videos.index'));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that default videos are visible on the page
        $defaultVideos = Video::where('is_default', true)->get();
        foreach ($defaultVideos as $video) {
            $response->assertSee($video->title);
            $response->assertSee($video->description);
        }
    }

    public function test_not_logged_users_can_see_default_videos_page()
    {
        // Visit the default videos page without logging in
        $response = $this->get(route('videos.index'));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that default videos are visible on the page
        $defaultVideos = Video::where('is_default', true)->get();
        foreach ($defaultVideos as $video) {
            $response->assertSee($video->title);
            $response->assertSee($video->description);
        }
    }
}

