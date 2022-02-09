<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->sentence(),
            'model' => $this->faker->unique()->word(),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomNumber(5),
            'is_active' => $this->faker->boolean(),
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
        ];
    }

    /**
     * Indicate that the product is active.
     *
     * @return static
     */
    public function active()
    {
        return $this->state(['is_active' => true]);
    }

    /**
     * Indicate that the product is inactive.
     *
     * @return static
     */
    public function inactive()
    {
        return $this->state(['is_active' => false]);
    }

    /**
     * Attach default image.
     *
     * @return static
     */
    public function withDefaultImage()
    {
        return $this->hasAttached(Image::factory(), ['is_default' => 1]);
    }
}
