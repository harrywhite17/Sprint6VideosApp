<?php

namespace Tests\Feature;

use App\Events\VideoCreated;
use App\Models\User;
use App\Models\Video;
use App\Notifications\VideoCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class VideoNotificationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create the 'superadmin' role
        Role::create(['name' => 'superadmin']);
    }

    public function test_video_created_event_is_dispatched()
    {
        Event::fake();

        $video = Video::factory()->create();
        event(new VideoCreated($video));

        Event::assertDispatched(VideoCreated::class);
    }

    public function test_push_notification_is_sent_when_video_is_created()
    {
        Notification::fake();

        // Create a user with the 'superadmin' role
        $admin = User::factory()->create();
        $admin->assignRole('superadmin');

        $video = Video::factory()->create();
        event(new VideoCreated($video));

        Notification::assertSentTo(
            [$admin],
            VideoCreatedNotification::class
        );
    }
}