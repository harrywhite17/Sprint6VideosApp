<?php

namespace Tests\Feature\Video;

use Tests\TestCase;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    private function loginAsVideoManager()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view videos', 'create videos', 'edit videos', 'delete videos');
        $this->actingAs($user);
        return $user;
    }

    private function loginAsSuperAdmin()
    {
        $user = User::factory()->create(['super_admin' => true]);
        $this->actingAs($user);
        return $user;
    }

    private function loginAsRegularUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    public function test_user_with_permissions_can_see_add_videos()
    {
        $this->loginAsVideoManager();
        $response = $this->get(route('videos.create'));
        $response->assertStatus(200);
    }

    public function test_user_without_videos_manage_create_cannot_see_add_videos()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('videos.create'));
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_store_videos()
    {
        $this->loginAsVideoManager();
        $videoData = Video::factory()->make()->toArray();
        $response = $this->post(route('videos.store'), $videoData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('videos', $videoData);
    }

    public function test_user_without_permissions_cannot_store_videos()
    {
        $this->loginAsRegularUser();
        $videoData = Video::factory()->make()->toArray();
        $response = $this->post(route('videos.store'), $videoData);
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_destroy_videos()
    {
        $this->loginAsVideoManager();
        $video = Video::factory()->create();
        $response = $this->delete(route('videos.destroy', $video));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('videos', ['id' => $video->id]);
    }

    public function test_user_without_permissions_cannot_destroy_videos()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create();
        $response = $this->delete(route('videos.destroy', $video));
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_see_edit_videos()
    {
        $this->loginAsVideoManager();
        $video = Video::factory()->create();
        $response = $this->get(route('videos.edit', $video));
        $response->assertStatus(200);
    }

    public function test_user_without_permissions_cannot_see_edit_videos()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create();
        $response = $this->get(route('videos.edit', $video));
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_update_videos()
    {
        $this->loginAsVideoManager();
        $video = Video::factory()->create();
        $updatedData = Video::factory()->make()->toArray();
        $response = $this->put(route('videos.update', $video), $updatedData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('videos', $updatedData);
    }

    public function test_user_without_permissions_cannot_update_videos()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create();
        $updatedData = Video::factory()->make()->toArray();
        $response = $this->put(route('videos.update', $video), $updatedData);
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_manage_videos()
    {
        $this->loginAsVideoManager();
        $response = $this->get(route('videos.manage'));
        $response->assertStatus(200);
    }

    public function test_regular_users_cannot_manage_videos()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('videos.manage'));
        $response->assertStatus(403);
    }

    public function test_guest_users_cannot_manage_videos()
    {
        $response = $this->get(route('videos.manage'));
        $response->assertStatus(302); // Redirect to login
    }

    public function test_superadmins_can_manage_videos()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('videos.manage'));
        $response->assertStatus(200);
    }
}