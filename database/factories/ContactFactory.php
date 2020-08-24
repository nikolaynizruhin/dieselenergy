<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contact;
use App\Customer;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'customer_id' => factory(Customer::class),
        'subject' => $faker->sentence,
        'message' => $faker->paragraph,
    ];
});
