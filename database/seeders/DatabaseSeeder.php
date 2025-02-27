<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Helpers\VideoHelper;
use UserHelpers;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create users
        $userHelpers = new UserHelpers();

        // Create permission and roles
        $userHelpers->create_permissions();

        $userHelpers->create_default_professor();
        $userHelpers->create_regular_user();
        $userHelpers->create_video_manager_user();
        $userHelpers->create_superadmin_user();

        // Create default videos
        VideoHelper::create_default_video();
    }
}