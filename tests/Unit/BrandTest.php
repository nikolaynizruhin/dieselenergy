<?php

use App\Models\Brand;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

it('has many products', function () {
    $brand = Brand::factory()
        ->hasProducts(1)
        ->create();

    $this->assertInstanceOf(Collection::class, $brand->products);
});

it('has currency', function () {
    $brand = Brand::factory()->create();

    $this->assertInstanceOf(Currency::class, $brand->currency);
});
