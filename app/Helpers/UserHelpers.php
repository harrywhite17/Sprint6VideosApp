<?php

use App\Models\User;
use App\Models\Team;

if (!function_exists('create_default_professor')) {
    function create_default_professor()
    {
        $professor = User::create([
            'name' => 'Default Professor',
            'email' => 'professor@videosapp.com',
            'password' => \Hash::make('123456789'),
            'super_admin' => false,
        ]);

        add_personal_team($professor);

        return $professor;
    }
}

if (!function_exists('add_personal_team')) {
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

if (!function_exists('create_regular_user')) {
    function create_regular_user()
    {
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'regular@videosapp.com',
            'password' => \Hash::make('123456789'),
            'super_admin' => false,
        ]);

        add_personal_team($user);

        return $user;
    }
}

if (!function_exists('create_video_manager_user')) {
    function create_video_manager_user()
    {
        $user = User::create([
            'name' => 'Video Manager',
            'email' => 'videosmanager@videosapp.com',
            'password' => \Hash::make('123456789'),
            'super_admin' => false,
        ]);

        add_personal_team($user);

        return $user;
    }
}

if (!function_exists('create_superadmin_user')) {
    function create_superadmin_user()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@videosapp.com',
            'password' => \Hash::make('123456789'),
            'super_admin' => true,
        ]);

        add_personal_team($user);

        return $user;
    }
}

if (!function_exists('define_gates')) {
    function define_gates()
    {
        \Illuminate\Support\Facades\Gate::define('manage-videos', function ($user) {
            return $user->isSuperAdmin() || $user->hasRole('video-manager');
        });
    }
}

if (!function_exists('create_permissions')) {
    function create_permissions()
    {
        $permissions = [
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'regular' => ['view videos'],
            'video-manager' => ['view videos', 'create videos', 'edit videos', 'delete videos'],
            'super-admin' => $permissions,
        ];

        foreach ($roles as $role => $rolePermissions) {
            $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => $role]);
            $role->syncPermissions($rolePermissions);
        }
    }
}