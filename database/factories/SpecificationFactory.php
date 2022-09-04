<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specification>
 */
class SpecificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => Category::factory(),
            'attribute_id' => Attribute::factory(),
            'is_featured' => fake()->boolean(),
        ];
    }

    /**
     * Indicate that the media is featured.
     *
     * @return static
     */
    public function featured()
    {
        return $this->state(['is_featured' => 1]);
    }

    /**
     * Indicate that the media is default.
     *
     * @return static
     */
    public function regular()
    {
        return $this->state(['is_featured' => 0]);
    }
}
