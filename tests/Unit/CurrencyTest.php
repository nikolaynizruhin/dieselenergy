<?php

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

it('has many brands', function () {
    $currency = Currency::factory()
        ->hasBrands(1)
        ->create();

    expect($currency->brands)->toBeInstanceOf(Collection::class);
});
