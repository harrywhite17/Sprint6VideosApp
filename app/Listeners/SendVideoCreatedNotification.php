<?php

namespace App\Listeners;

use App\Events\VideoCreated;
use App\Models\User;
use App\Notifications\VideoCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendVideoCreatedNotification
{
    /**
     * Handle the event.
     *
     * @param \App\Events\VideoCreated $event
     * @return void
     */
    public function handle(VideoCreated $event)
    {
        $admins = User::role('superadmin')->get();

        Notification::send($admins, new VideoCreatedNotification($event->video));
    }
}