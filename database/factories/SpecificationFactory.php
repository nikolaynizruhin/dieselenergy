<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attribute;
use App\Category;
use App\Specification;
use Faker\Generator as Faker;

$factory->define(Specification::class, function (Faker $faker) {
    return [
        'category_id' => factory(Category::class),
        'attribute_id' => factory(Attribute::class),
        'is_featured' => $faker->boolean,
    ];
});
