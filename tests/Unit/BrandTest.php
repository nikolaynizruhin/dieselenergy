<?php

use App\Models\Brand;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

it('has many products', function () {
    $brand = Brand::factory()
        ->hasProducts(1)
        ->create();

    expect($brand->products)->toBeInstanceOf(Collection::class);
});

it('has currency', function () {
    $brand = Brand::factory()->create();

    expect($brand->currency)->toBeInstanceOf(Currency::class);
});
