<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'slug' => fake()->unique()->slug(),
            'title' => fake()->unique()->sentence(),
            'excerpt' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'image_id' => Image::factory(),
        ];
    }
}
