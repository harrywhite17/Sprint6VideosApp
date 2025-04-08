<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\UserHelpers;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $userHelpers = new UserHelpers();
        $userHelpers->create_permissions();
    }
}