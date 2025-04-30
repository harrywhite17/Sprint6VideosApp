<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewVideoNotification extends Notification
{
    use Queueable;

    public $video;

    public function __construct($video)
    {
        $this->video = $video;
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'video' => $this->video,
            'user' => auth()->user()->name,
            'action' => 'created a new video',
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'video' => [
                'id' => $this->video->id,
                'title' => $this->video->title,
            ],
            'user' => auth()->user()->name,
            'action' => 'created a new video',
        ];
    }
}