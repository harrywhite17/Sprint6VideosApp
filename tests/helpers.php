<?php


use App\Models\User;

function create_default_user()
{
    return User::factory()->create([
        'name' => config('userdefaults.default_user.name'),
        'email' => config('userdefaults.default_user.email'),
    ]);
}

function create_default_professor()
{
    $professor = User::create([
        'name' => 'Default Professor',
        'email' => 'professor@videosapp.com',
        'password' => bcrypt('password'),
        'super_admin' => true,
    ]);
}