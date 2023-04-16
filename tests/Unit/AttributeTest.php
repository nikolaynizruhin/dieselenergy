<?php

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

it('has many categories', function () {
    $attribute = Attribute::factory()
        ->hasCategories()
        ->create();

    $this->assertInstanceOf(Collection::class, $attribute->categories);
});

it('has many products', function () {
    $attribute = Attribute::factory()
        ->hasAttached(Product::factory(), [
            'value' => $value = fake()->randomDigit(),
        ])->create();

    $this->assertInstanceOf(Collection::class, $attribute->products);
    $this->assertEquals($value, $attribute->products->first()->pivot->value);
});
