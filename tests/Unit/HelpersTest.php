<?php

namespace Tests\Unit;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use App\Helpers\UserHelpers;

class HelpersTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_default_user()
    {
        $user = (new UserHelpers())->create_default_user();

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(config('userdefaults.default_user.name', 'Default User'), $user->name);
        $this->assertEquals(config('userdefaults.default_user.email', 'default@example.com'), $user->email);
        $this->assertTrue(\Hash::check(config('userdefaults.default_user.password', 'password'), $user->password));
        $this->assertInstanceOf(Team::class, $user->currentTeam);
    }

    public function test_create_default_teacher()
    {
        $teacher = (new UserHelpers())->create_default_teacher();

        $this->assertInstanceOf(User::class, $teacher);
        $this->assertEquals(config('userdefaults.default_teacher.name', 'Default Teacher'), $teacher->name);
        $this->assertEquals(config('userdefaults.default_teacher.email', 'teacher@example.com'), $teacher->email);
        $this->assertTrue(\Hash::check(config('userdefaults.default_teacher.password', 'password'), $teacher->password));
        $this->assertInstanceOf(Team::class, $teacher->currentTeam);
    }

    /** @test */
    public function test_create_default_video()
    {
        // Create a user first to get a valid user_id
        $user = (new UserHelpers())->create_default_user();

        // Pass the user_id to create_default_video
        $video = $this->create_default_video($user->id);

        $this->assertInstanceOf(Video::class, $video);
        $this->assertEquals('Default Title', $video->title);
        $this->assertEquals('Default Description', $video->description);
        $this->assertEquals('https://default.url', $video->url);
        $this->assertTrue((bool) $video->is_default, "Expected is_default to be true, got {$video->is_default}");
        $this->assertEquals($user->id, $video->user_id); // Verify user_id was set
    }

    private function create_default_video($userId)
    {
        $video = Video::create([
            'title' => 'Default Title',
            'description' => 'Default Description',
            'url' => 'https://default.url',
            'published_at' => now(),
            'is_default' => true,
            'user_id' => $userId,
        ]);

        logger()->info('Video is_default after save: ' . json_encode($video->is_default));
        return $video;
    }
}