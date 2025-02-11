<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsSeeder::class,
            UsersSeeder::class,
        ]);
    }
}

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'regular' => ['view videos'],
            'video-manager' => ['view videos', 'create videos', 'edit videos', 'delete videos'],
            'super-admin' => $permissions,
        ];

        foreach ($roles as $role => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $role]);
            $role->syncPermissions($rolePermissions);
        }
    }
}

class UsersSeeder extends Seeder
{
    public function run()
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@videosapp.com',
            'password' => bcrypt('123456789'),
            'super_admin' => true,
        ]);
        $superAdmin->assignRole('super-admin');

        $videoManager = User::create([
            'name' => 'Video Manager',
            'email' => 'videosmanager@videosapp.com',
            'password' => bcrypt('123456789'),
            'super_admin' => false,
        ]);
        $videoManager->assignRole('video-manager');

        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'regular@videosapp.com',
            'password' => bcrypt('123456789'),
            'super_admin' => false,
        ]);
        $regularUser->assignRole('regular');
    }
}