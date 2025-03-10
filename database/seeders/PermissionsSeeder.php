<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Define permissions
        $permissions = [
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles
        $roles = [
            'video-manager' => $permissions, // video-manager has all video permissions
            'super-admin' => Permission::pluck('name')->toArray(), // super-admin has all permissions
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
