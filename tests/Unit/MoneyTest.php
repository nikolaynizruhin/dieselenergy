<?php

use App\Models\Currency;
use App\Support\Money;

beforeEach(function () {
    $this->money = new Money(10000);
});

it('can get coins', function () {
    expect($this->money->coins())->toEqual(10000);
});

it('can get decimal', function () {
    expect($this->money->decimal())->toEqual(100.00);
});

it('can be formatted', function () {
    expect($this->money->format())->toEqual('100 ₴');
});

it('can be formatted with currency', function () {
    $currency = Currency::factory()->create(['symbol' => '$']);
    $money = new Money(10000, $currency);

    expect($money->format())->toEqual('100 $');
});

it('can be converted to uah', function () {
    $currency = Currency::factory()->create(['rate' => 33.3057]);
    $money = new Money(10000, $currency);

    expect($money->toUAH()->coins())->toEqual(333057);
});
