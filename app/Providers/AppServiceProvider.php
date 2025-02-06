<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        // Registrar les polítiques d'autorització
        Gate::policy(\App\Models\Video::class, \App\Policies\VideoPolicy::class);

        // Definir les portes d'accés
        Gate::define('manage-videos', function ($user) {
            return $user->isSuperAdmin() || $user->hasRole('video-manager');
        });
    }
}