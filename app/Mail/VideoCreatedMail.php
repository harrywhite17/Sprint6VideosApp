<?php

namespace App\Mail;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VideoCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function build()
    {
        return $this->subject('New Video Created')
            ->view('emails.video-created')
            ->with([
                'title' => $this->video->title,
                'description' => $this->video->description,
            ]);
    }
}