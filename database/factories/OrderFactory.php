<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'status' => $this->faker->randomElement(Status::all()),
            'total' => $this->faker->randomNumber(5),
            'notes' => $this->faker->sentence(),
        ];
    }
}
