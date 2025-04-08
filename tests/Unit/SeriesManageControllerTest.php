<?php

namespace Tests\Unit;

use App\Models\Series;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SeriesManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the required roles
        Role::create(['name' => 'video-manager', 'guard_name' => 'web']);
        Role::create(['name' => 'user', 'guard_name' => 'web']);
        Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
    }

    private function loginAsVideoManager()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $user->assignRole('video-manager');
        $this->actingAs($user);
    }

    private function loginAsSuperAdmin()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $user->assignRole('super-admin');
        $this->actingAs($user);
    }

    private function loginAsRegularUser()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $user->assignRole('user');
        $this->actingAs($user);
    }

    public function test_user_with_permissions_can_see_add_series()
    {
        $this->loginAsVideoManager();
        $response = $this->get('/series/manage/create');
        $response->assertStatus(200);
    }

    public function test_user_without_series_manage_create_cannot_see_add_series()
    {
        $this->loginAsRegularUser();
        $response = $this->get('/series/manage/create');
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_store_series()
    {
        $this->loginAsVideoManager();
        $response = $this->post('/series/manage', [
            'title' => 'Test Series',
            'description' => 'Test Description',
            'image' => 'test.jpg',
            'user_name' => 'Test User',
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('series', ['title' => 'Test Series']);
    }

    public function test_user_without_permissions_cannot_store_series()
    {
        $this->loginAsRegularUser();
        $response = $this->post('/series/manage', [
            'title' => 'Test Series',
            'description' => 'Test Description',
            'image' => 'test.jpg',
            'user_name' => 'Test User',
        ]);
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_destroy_series()
    {
        $this->loginAsVideoManager();
        $series = Series::factory()->create();
        $response = $this->delete("/series/manage/{$series->id}");
        $response->assertStatus(302);
        $this->assertDatabaseMissing('series', ['id' => $series->id]);
    }

    public function test_user_without_permissions_cannot_destroy_series()
    {
        $this->loginAsRegularUser();
        $series = Series::factory()->create();
        $response = $this->delete("/series/manage/{$series->id}");
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_see_edit_series()
    {
        $this->loginAsVideoManager();
        $series = Series::factory()->create();
        $response = $this->get("/series/manage/{$series->id}/edit");
        $response->assertStatus(200);
    }

    public function test_user_without_permissions_cannot_see_edit_series()
    {
        $this->loginAsRegularUser();
        $series = Series::factory()->create();
        $response = $this->get("/series/manage/{$series->id}/edit");
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_update_series()
    {
        $this->loginAsVideoManager();
        $series = Series::factory()->create();
        $response = $this->put("/series/manage/{$series->id}", [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'image' => 'updated.jpg',
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('series', ['title' => 'Updated Title']);
    }

    public function test_user_without_permissions_cannot_update_series()
    {
        $this->loginAsRegularUser();
        $series = Series::factory()->create();
        $response = $this->put("/series/manage/{$series->id}", [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'image' => 'updated.jpg',
        ]);
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_manage_series()
    {
        $this->loginAsVideoManager();
        $response = $this->get('/series/manage');
        $response->assertStatus(200);
    }

    public function test_regular_users_cannot_manage_series()
    {
        $this->loginAsRegularUser();
        $response = $this->get('/series/manage');
        $response->assertStatus(403);
    }

    public function test_guest_users_cannot_manage_series()
    {
        $response = $this->get('/series/manage');
        $response->assertStatus(302); // Adjust based on your app's behavior
        $response->assertRedirect('/login'); // Adjust the login route if different
    }

    public function test_videomanagers_can_manage_series()
    {
        $this->loginAsVideoManager();
        $response = $this->get('/series/manage');
        $response->assertStatus(200);
    }

    public function test_superadmins_can_manage_series()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get('/series/manage');
        $response->assertStatus(200);
    }
}