<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->defineGates();
        $this->createPermissions();
    }

    /**
     * Define gates for the application.
     *
     * @return void
     */
    protected function defineGates()
    {
        Gate::define('manage-videos', function ($user) {
            return $user->hasRole('video-manager') || $user->isSuperAdmin();
        });
    }

    /**
     * Create permissions for the application.
     *
     * @return void
     */
    protected function createPermissions()
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