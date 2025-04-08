<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\UserHelpers;
use App\Models\Series;
use App\Helpers\VideoHelper;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            SeriesPermissionsSeeder::class,
        ]);

        $userHelpers = new UserHelpers();

        $userHelpers->create_permissions();

        $userHelpers->create_default_professor();
        $userHelpers->create_regular_user();
        $userHelpers->create_video_manager_user();
        $superadmin = $userHelpers->create_superadmin_user(); // Assuming this returns a User model

        $series = Series::create([
            'title' => 'Default Series',
            'description' => 'This is a default series.',
            'user_name' => 'system',
        ]);

        $videos = VideoHelper::create_default_video($superadmin->id); // Pass superadmin's ID
        foreach ($videos as $video) {
            $video->series()->associate($series);
            $video->save();
        }
    }
}