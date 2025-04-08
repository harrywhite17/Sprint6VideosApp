<?php

namespace Database\Factories;

use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    protected $model = Series::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl,
            'user_name' => $this->faker->name,
            'user_photo_url' => $this->faker->imageUrl,
            'published_at' => $this->faker->dateTime,
        ];
    }
}