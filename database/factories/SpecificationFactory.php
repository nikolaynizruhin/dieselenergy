<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attribute;
use App\Category;
use App\Specification;
use Faker\Generator as Faker;

$factory->define(Specification::class, function (Faker $faker) {
    return [
        'attributable_id' => factory(Category::class),
        'attributable_type' => Category::class,
        'attribute_id' => factory(Attribute::class),
    ];
});