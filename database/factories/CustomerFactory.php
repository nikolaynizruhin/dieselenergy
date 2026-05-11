<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Rules\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->regexify(Phone::REGEX),
            'notes' => fake()->sentence(),
        ];
    }
}
