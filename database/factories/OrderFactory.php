<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'customer_id' => factory(Customer::class),
        'status' => $faker->randomElement(Order::statuses()),
        'total' => $faker->randomDigit,
        'notes' => $faker->sentence,
    ];
});
