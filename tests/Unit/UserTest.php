<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create permissions
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
        Auth::login($user);

        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
    }

    public function testUserWithPermissionsCanSeeDefaultUsersPage()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view users');
        Auth::login($user);

        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
    }

    public function testNotLoggedUsersCannotSeeDefaultUsersPage()
    {
        $response = $this->get(route('users.index'));
        $response->assertRedirect(route('login'));
    }

    public function testUserWithoutPermissionsCanSeeUserShowPage()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->get(route('users.show', ['user' => $user->id]));
        $response->assertStatus(200);
    }

    public function testUserWithPermissionsCanSeeUserShowPage()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view users');
        Auth::login($user);

        $response = $this->get(route('users.show', ['user' => $user->id]));
        $response->assertStatus(200);
    }

    public function testNotLoggedUsersCannotSeeUserShowPage()
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.show', ['user' => $user->id]));
        $response->assertRedirect(route('login'));
    }
}