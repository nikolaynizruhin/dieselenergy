<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'status' => fake()->randomElement(OrderStatus::all()),
            'total' => fake()->randomNumber(5),
            'notes' => fake()->sentence(),
        ];
    }
}
