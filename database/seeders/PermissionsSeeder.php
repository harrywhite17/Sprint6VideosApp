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
            'view series',
            'create series',
            'edit series',
            'delete series',
            'create videos',
            'add videos to series',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to superadmin
        $superadminRole->syncPermissions($permissions);

        // Assign specific permissions to regular user
        $userRole->givePermissionTo([
            'view series',
            'create series',
            'add videos to series',
            'create videos',
        ]);
    }
}