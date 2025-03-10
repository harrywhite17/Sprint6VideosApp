<?php

use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserHelpers {

    public function create_default_user()
    {
        $user = User::create([
            'name' => config('userdefaults.default_user.name'),
            'email' => config('userdefaults.default_user.email'),
            'password' => Hash::make(config('userdefaults.default_user.password')),
        ]);

        $team = Team::create([
            'name' => $user->name . "'s Team",
            'user_id' => $user->id, // Ensure user_id is set
            'personal_team' => true,
        ]);

        $user->currentTeam()->associate($team);
        $user->save();

        return $user;
    }

    public function create_default_teacher()
    {
        $teacher = User::create([
            'name' => config('userdefaults.default_teacher.name'),
            'email' => config('userdefaults.default_teacher.email'),
            'password' => Hash::make(config('userdefaults.default_teacher.password')),
        ]);

        $team = Team::create([
            'name' => $teacher->name . "'s Team",
            'user_id' => $teacher->id, // Ensure user_id is set
            'personal_team' => true,
        ]);

        $teacher->currentTeam()->associate($team);
        $teacher->save();

        return $teacher;
    }

    public static function createPermissionsAndAssignToSuperAdmin()
    {
        // Define permissions
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

        // Create permissions if they don't exist
        foreach (array_merge($videoPermissions, $userPermissions) as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles
        $roles = [
            'video-manager' => $videoPermissions, // video-manager has all video permissions
            'super-admin' => Permission::pluck('name')->toArray(), // super-admin has all permissions
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}