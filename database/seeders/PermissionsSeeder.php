<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use UserHelpers;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        UserHelpers::createPermissionsAndAssignToSuperAdmin();
    }
}