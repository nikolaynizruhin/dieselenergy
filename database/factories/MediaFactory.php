<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_id' => Image::factory(),
            'product_id' => Product::factory(),
            'is_default' => fake()->boolean(),
        ];
    }

    /**
     * Indicate that the media is default.
     */
    public function default(): static
    {
        return $this->state(['is_default' => 1]);
    }

    /**
     * Indicate that the media is default.
     */
    public function regular(): static
    {
        return $this->state(['is_default' => 0]);
    }
}
