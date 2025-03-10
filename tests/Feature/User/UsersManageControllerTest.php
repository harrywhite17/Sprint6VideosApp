<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles and permissions
        Role::firstOrCreate(['name' => 'video-manager']);
        Role::firstOrCreate(['name' => 'super-admin']);
        Role::firstOrCreate(['name' => 'user-manager']);
        Permission::firstOrCreate(['name' => 'manage users']);
    }

    protected function loginAsVideoManager()
    {
        $user = User::factory()->create();
        $user->assignRole('video-manager');
        Auth::login($user);
    }

    protected function loginAsSuperAdmin()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');
        Auth::login($user);
    }

    protected function loginAsRegularUser()
    {
        $user = User::factory()->create();
        Auth::login($user);
    }

    public function testUserWithPermissionsCanSeeAddUsers()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.manage.create'));
        $response->assertStatus(200);
    }

    public function testUserWithoutUsersManageCreateCannotSeeAddUsers()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('users.manage.create'));
        $response->assertStatus(403);
    }

    public function testUserWithPermissionsCanStoreUsers()
    {
        $this->loginAsSuperAdmin();
        $response = $this->post(route('users.manage.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect(route('users.manage.index'));
    }

    public function testUserWithoutPermissionsCannotStoreUsers()
    {
        $this->loginAsRegularUser();
        $response = $this->post(route('users.manage.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(403);
    }

    public function testUserWithPermissionsCanDestroyUsers()
    {
        $this->loginAsSuperAdmin();
        $user = User::factory()->create();
        $response = $this->delete(route('users.manage.destroy', $user->id));
        $response->assertRedirect(route('users.manage.index'));
    }

    public function testUserWithoutPermissionsCannotDestroyUsers()
    {
        $this->loginAsRegularUser();
        $user = User::factory()->create();
        $response = $this->delete(route('users.manage.destroy', $user->id));
        $response->assertStatus(403);
    }

    public function testUserWithPermissionsCanSeeEditUsers()
    {
        $this->loginAsSuperAdmin();
        $user = User::factory()->create();
        $response = $this->get(route('users.manage.edit', $user->id));
        $response->assertStatus(200);
    }

    public function testUserWithoutPermissionsCannotSeeEditUsers()
    {
        $this->loginAsRegularUser();
        $user = User::factory()->create();
        $response = $this->get(route('users.manage.edit', $user->id));
        $response->assertStatus(403);
    }

    public function testUserWithPermissionsCanUpdateUsers()
    {
        $this->loginAsSuperAdmin();
        $user = User::factory()->create();
        $response = $this->put(route('users.manage.update', $user->id), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect(route('users.manage.index'));
    }

    public function testUserWithoutPermissionsCannotUpdateUsers()
    {
        $this->loginAsRegularUser();
        $user = User::factory()->create();
        $response = $this->put(route('users.manage.update', $user->id), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(403);
    }

    public function testUserWithPermissionsCanManageUsers()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(200);
    }

    public function testRegularUsersCannotManageUsers()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(403);
    }

    public function testGuestUsersCannotManageUsers()
    {
        $response = $this->get(route('users.manage.index'));
        $response->assertRedirect(route('login'));
    }

    public function testSuperadminsCanManageUsers()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(200);
    }
}