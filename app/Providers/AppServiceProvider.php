<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
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

        Route::aliasMiddleware('role', RoleMiddleware::class);
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
}