<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use App\Media;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Media::class, function (Faker $faker) {
    return [
        'image_id' => factory(Image::class),
        'product_id' => factory(Product::class),
        'is_default' => $faker->boolean,
    ];
});

$factory->state(Media::class, 'default', ['is_default' => 1]);
