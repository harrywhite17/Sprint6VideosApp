<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Crear els permisos
        create_permissions();

        // Crear els usuaris per defecte
        create_superadmin_user();
        create_regular_user();
        create_video_manager_user();
    }
}