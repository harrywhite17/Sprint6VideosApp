<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoCreated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $video;

    public function __construct($video)
    {
        $this->video = $video;
    }

    public function broadcastOn()
    {
        return ['videos'];
    }

    public function broadcastAs()
    {
        return 'video.created';
    }
}