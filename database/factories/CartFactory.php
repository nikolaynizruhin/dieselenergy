<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cart;
use App\Order;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Cart::class, function (Faker $faker) {
    return [
        'order_id' => factory(Order::class),
        'product_id' => factory(Product::class),
        'quantity' => $faker->randomDigit,
    ];
});
