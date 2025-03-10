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
            'is_default' => false,
            'published_at' => $this->faker->optional()->dateTime,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->url,
            'previous_id' => null,
            'next_id' => null,
            'series_id' => null,
            'created_at' => $this->faker->dateTime,
            'user_id' => User::factory(),
        ];
    }
}