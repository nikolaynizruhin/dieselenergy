<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use App\Category;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->sentence,
        'description' => $faker->paragraph,
        'price' => $faker->randomNumber(5),
        'is_active' => $faker->boolean,
        'brand_id' => factory(Brand::class),
        'category_id' => factory(Category::class),
    ];
});

$factory->state(Product::class, 'active', ['is_active' => true]);

$factory->state(Product::class, 'inactive', ['is_active' => false]);
