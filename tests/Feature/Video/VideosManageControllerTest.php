<?php

namespace Tests\Feature\Video;

use Tests\TestCase;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\PermissionsSeeder::class);
    }

    private function loginAsVideoManager()
    {
        $user = User::factory()->create();
        $user->assignRole('video-manager');
        $this->actingAs($user);
        return $user;
    }

    private function loginAsSuperAdmin()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');
        $this->actingAs($user);
        return $user;
    }

    private function loginAsRegularUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    /** @test */
    public function user_with_permissions_can_see_add_videos()
    {
        $this->loginAsVideoManager();
        $response = $this->get(route('videos.manage.create'));
        $response->assertStatus(200);
    }

    /** @test */
    public function user_without_videos_manage_create_cannot_see_add_videos()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('videos.manage.create'));
        $response->assertStatus(403);
    }

    /** @test */
    public function user_without_permissions_cannot_store_videos()
    {
        $this->loginAsRegularUser();
        $videoData = Video::factory()->make()->toArray();
        $response = $this->post(route('videos.manage.store'), $videoData);
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_permissions_can_destroy_videos()
    {
        $user = $this->loginAsVideoManager();
        $video = Video::factory()->create(['user_id' => $user->id]);
        $response = $this->delete(route('videos.manage.destroy', $video));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('videos', ['id' => $video->id]);
    }

    /** @test */
    public function user_without_permissions_cannot_destroy_videos()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create();
        $response = $this->delete(route('videos.manage.destroy', $video));
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_permissions_can_see_edit_videos()
    {
        $user = $this->loginAsVideoManager();
        $video = Video::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('videos.manage.edit', $video));
        $response->assertStatus(200);
    }

    /** @test */
    public function user_without_permissions_cannot_see_edit_videos()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create();
        $response = $this->get(route('videos.manage.edit', $video));
        $response->assertStatus(403);
    }


    /** @test */
    public function user_without_permissions_cannot_update_videos()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create();
        $updatedData = Video::factory()->make()->toArray();
        $response = $this->put(route('videos.manage.update', $video), $updatedData);
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_permissions_can_manage_videos()
    {
        $this->loginAsVideoManager();
        $response = $this->get(route('videos.manage.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function regular_users_cannot_manage_videos()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('videos.manage.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_users_cannot_manage_videos()
    {
        $response = $this->get(route('videos.manage.index'));
        $response->assertStatus(302); // Redirect to login
    }

    /** @test */
    public function superadmins_can_manage_videos()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('videos.manage.index'));
        $response->assertStatus(200);
    }
}