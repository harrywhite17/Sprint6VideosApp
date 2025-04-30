<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VideoCreatedNotification extends Notification
{
    use Queueable;

    public $video;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Video $video
     */
    public function __construct($video)
    {
        $this->video = $video;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Video Created')
            ->line('A new video has been created:')
            ->line('Title: ' . $this->video->title)
            ->line('Description: ' . $this->video->description)
            ->action('View Video', url(route('videos.show', $this->video->id)))
            ->line('Thank you for using our application!');
    }
}