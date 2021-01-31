<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->sentence,
            'model' => $this->faker->unique()->word,
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomNumber(5),
            'is_active' => $this->faker->boolean,
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
        ];
    }

    /**
     * Indicate that the product is active.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function active()
    {
        return $this->state(['is_active' => true]);
    }

    /**
     * Indicate that the product is inactive.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inactive()
    {
        return $this->state(['is_active' => false]);
    }

    /**
     * Attach default image.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withDefaultImage()
    {
        return $this->hasAttached(Image::factory(), ['is_default' => 1]);
    }
}
