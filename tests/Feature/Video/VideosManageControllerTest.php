<?php

namespace Tests\Feature\Videos;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_permissions_can_authenticate()
    {
        $this->loginAsVideoManager();
        $this->assertAuthenticated();
    }

    /** @test */
    public function regular_users_can_authenticate()
    {
        $this->loginAsRegularUser();
        $this->assertAuthenticated();
    }

    /** @test */
    public function guest_users_are_not_authenticated()
    {
        $this->assertGuest();
    }

    /** @test */
    public function superadmins_can_authenticate()
    {
        $this->loginAsSuperAdmin();
        $this->assertAuthenticated();
    }

    protected function loginAsVideoManager()
    {
        $role = Role::firstOrCreate(['name' => 'video-manager', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole($role);
        $this->actingAs($user);
    }

    protected function loginAsSuperAdmin()
    {
        $user = User::factory()->create(['super_admin' => true]);
        $this->actingAs($user);
    }

    protected function loginAsRegularUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }
}
