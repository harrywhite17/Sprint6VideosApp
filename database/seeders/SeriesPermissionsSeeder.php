<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class SeriesPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'view series',
            'create series',
            'edit series',
            'delete series',
            'create videos',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to superadmin role
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $superadminRole->syncPermissions($permissions);

        // Assignar permisos al rol d'usuari regular
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->givePermissionTo('create videos'); // Assignar permís específic

        // Assign superadmin role to users
        $superadminUsers = User::where('is_superadmin', true)->get();
        foreach ($superadminUsers as $user) {
            $user->assignRole($superadminRole);
        }
    }
}