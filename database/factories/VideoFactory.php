<?php

// database/factories/VideoFactory.php

namespace Database\Factories;

use App\Models\Video;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'is_default' => $this->faker->boolean,
            'published_at' => $this->faker->dateTime,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->url,
            'previous_id' => null,
            'next_id' => null,
            'series_id' => \App\Models\Series::factory(), // Ensure this references a valid Series
            'user_id' => \App\Models\User::factory(),
        ];
    }
}