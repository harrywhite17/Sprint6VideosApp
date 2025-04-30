<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\VideoCreated::class => [
            \App\Listeners\SendVideoCreatedNotification::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}