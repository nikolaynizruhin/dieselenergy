<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::factory(),
            'attribute_id' => Attribute::factory(),
            'is_featured' => $this->faker->boolean(),
        ];
    }
}
