<?php

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

it('has many categories', function () {
    $attribute = Attribute::factory()
        ->hasCategories()
        ->create();

    expect($attribute->categories)->toBeInstanceOf(Collection::class);
});

it('has many products', function () {
    $attribute = Attribute::factory()
        ->hasAttached(Product::factory(), [
            'value' => $value = fake()->randomDigit(),
        ])->create();

    expect($attribute->products)->toBeInstanceOf(Collection::class);
    expect($attribute->products->first()->pivot->value)->toEqual($value);
});
