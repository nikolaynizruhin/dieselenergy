<?php

use App\Models\Currency;
use App\Support\Money;

beforeEach(function () {
    $this->money = new Money(10000);
});

it('can get coins', function () {
    $this->assertEquals(10000, $this->money->coins());
});

it('can get decimal', function () {
    $this->assertEquals(100.00, $this->money->decimal());
});

it('can be formatted', function () {
    $this->assertEquals('100 ₴', $this->money->format());
});

it('can be formatted with currency', function () {
    $currency = Currency::factory()->create(['symbol' => '$']);
    $money = new Money(10000, $currency);

    $this->assertEquals('100 $', $money->format());
});

it('can be converted to uah', function () {
    $currency = Currency::factory()->create(['rate' => 33.3057]);
    $money = new Money(10000, $currency);

    $this->assertEquals(333057, $money->toUAH()->coins());
});
