<?php

namespace Database\Factories;

use App\Models\Multimedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class MultimediaFactory extends Factory
{
    protected $model = Multimedia::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $this->faker->word . '.' . $this->faker->fileExtension,
            'path' => $this->faker->filePath(),
            'type' => $this->faker->randomElement(['photo', 'video']),
        ];
    }
}