<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles and permissions
        Role::firstOrCreate(['name' => 'user-manager']);
        Role::firstOrCreate(['name' => 'super-admin']);
        Permission::firstOrCreate(['name' => 'view users']);
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);
    }

    public function testIsSuperAdmin()
    {
        $superAdmin = new User(['super_admin' => true]);
        $this->assertTrue($superAdmin->isSuperAdmin());

        $regularUser = new User(['super_admin' => false]);
        $this->assertFalse($regularUser->isSuperAdmin());
    }

    public function testUserWithoutPermissionsCanSeeDefaultUsersPage()
    {
        $user = User::factory()->create();
        $user->assignRole('user-manager'); // Assign the required role
        Auth::login($user);

        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(200);
    }

    public function testUserWithPermissionsCanSeeDefaultUsersPage()
    {
        $user = User::factory()->create();
        $user->assignRole('user-manager'); // Assign the required role
        $user->givePermissionTo('view users'); // Assign the required permission
        Auth::login($user);

        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(200);
    }

    public function testNotLoggedUsersCannotSeeDefaultUsersPage()
    {
        $response = $this->get(route('users.manage.index'));
        $response->assertRedirect(route('login'));
    }

    public function testUserWithoutPermissionsCanSeeUserShowPage()
    {
        $user = User::factory()->create();
        $user->assignRole('user-manager'); // Assign the required role
        Auth::login($user);

        $response = $this->get(route('users.manage.show', ['user' => $user->id]));
        $response->assertStatus(200);
    }

    public function testUserWithPermissionsCanSeeUserShowPage()
    {
        $user = User::factory()->create();
        $user->assignRole('user-manager'); // Assign the required role
        $user->givePermissionTo('view users'); // Assign the required permission
        Auth::login($user);

        $response = $this->get(route('users.manage.show', ['user' => $user->id]));
        $response->assertStatus(200);
    }

    public function testNotLoggedUsersCannotSeeUserShowPage()
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.manage.show', ['user' => $user->id]));
        $response->assertRedirect(route('login'));
    }
}