<?php

use App\Models\User;
use App\Models\Team;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserHelpers {
    function create_default_professor()
    {
        $professor = User::create([
            'name' => 'Default Professor',
            'email' => 'professor@videosapp.com',
            'password' => Hash::make('123456789'),
            'super_admin' => true,
        ]);
        $this->add_personal_team($professor);
        $professor->assignRole('super-admin');

        return $professor;
    }

    function create_regular_user()
    {
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'regular@videosapp.com',
            'password' => Hash::make('123456789'),
            'super_admin' => false,
        ]);

        $this->add_personal_team($user);
        $user->assignRole('regular');

        return $user;
    }

    function create_video_manager_user()
    {
        $user = User::create([
            'name' => 'Video Manager',
            'email' => 'videosmanager@videosapp.com',
            'password' => Hash::make('123456789'),
            'super_admin' => false,
        ]);

        $this->add_personal_team($user);
        $user->assignRole('video-manager');

        return $user;
    }

    function create_superadmin_user()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@videosapp.com',
            'password' => Hash::make('123456789'),
            'super_admin' => true,
        ]);

        $this->add_personal_team($user);
        $user->assignRole('super-admin');

        return $user;
    }

    function create_permissions()
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
            $role->givePermissionTo($rolePermissions);
        }
    }

    function add_personal_team($user)
    {
        $team = Team::create([
            'user_id' => $user->id,
            'name' => $user->name . "'s Team",
            'personal_team' => true,
        ]);

        $user->current_team_id = $team->id;
        $user->save();
    }
}