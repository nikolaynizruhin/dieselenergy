<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique()->currencyCode(),
            'rate' => $this->faker->randomFloat(4, 1, 50),
            'symbol' => $this->faker->unique()->randomLetter(),
        ];
    }
}
