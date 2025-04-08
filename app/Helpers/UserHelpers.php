<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserHelpers
{
    public function create_default_user()
    {
        return $this->createUserIfNotExists(
            config('userdefaults.default_user.name', 'Default User'),
            config('userdefaults.default_user.email', 'default@example.com'),
            config('userdefaults.default_user.password', 'password')
        );
    }

    public function create_default_teacher()
    {
        return $this->createUserIfNotExists(
            config('userdefaults.default_teacher.name', 'Default Teacher'),
            config('userdefaults.default_teacher.email', 'teacher@example.com'),
            config('userdefaults.default_teacher.password', 'password')
        );
    }

    public function create_default_professor()
    {
        return $this->createUserIfNotExists(
            config('userdefaults.default_professor.name', 'Default Professor'),
            config('userdefaults.default_professor.email', 'professor@example.com'),
            config('userdefaults.default_professor.password', 'password')
        );
    }

    public function create_regular_user()
    {
        return $this->createUserIfNotExists(
            config('userdefaults.regular_user.name', 'Regular User'),
            config('userdefaults.regular_user.email', 'user@example.com'),
            config('userdefaults.regular_user.password', 'password')
        );
    }

    public function create_video_manager_user()
    {
        $user = $this->createUserIfNotExists(
            config('userdefaults.video_manager.name', 'Video Manager'),
            config('userdefaults.video_manager.email', 'videomanager@example.com'),
            config('userdefaults.video_manager.password', 'password')
        );
        $user->assignRole('video-manager');
        return $user;
    }

    public function create_superadmin_user()
    {
        $user = $this->createUserIfNotExists(
            config('userdefaults.super_admin.name', 'Super Admin'),
            config('userdefaults.super_admin.email', 'superadmin@example.com'),
            config('userdefaults.super_admin.password', 'password')
        );
        $user->assignRole('super-admin');
        return $user;
    }

    public function create_permissions()
    {
        $videoPermissions = [
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
        ];

        $userPermissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        foreach (array_merge($videoPermissions, $userPermissions) as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'video-manager' => $videoPermissions,
            'super-admin' => Permission::pluck('name')->toArray(),
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }

    private function createUserIfNotExists($name, $email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Create the user
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            // Create the team with explicit user_id assignment
            $team = new Team();
            $team->name = $user->name . "'s Team";
            $team->user_id = $user->id; // Explicitly set user_id
            $team->personal_team = true;
            $team->save();

            // Associate the team with the user
            $user->currentTeam()->associate($team);
            $user->save();
        }

        return $user;
    }
}