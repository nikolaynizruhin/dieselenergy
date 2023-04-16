<?php

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant sort currencies', function () {
    $this->get(route('admin.currencies.index', ['sort' => 'code']))
        ->assertRedirect(route('admin.login'));
});

test('admin can sort currencies by code ascending', function () {
    [$euro, $dollar] = Currency::factory()
        ->count(2)
        ->state(new Sequence(
            ['code' => 'EUR'],
            ['code' => 'USD'],
        ))->create();

    $this->login()
        ->get(route('admin.currencies.index', ['sort' => 'code']))
        ->assertSuccessful()
        ->assertViewIs('admin.currencies.index')
        ->assertViewHas('currencies')
        ->assertSeeInOrder([$euro->code, $dollar->code]);
});

test('admin can sort currencies by code descending', function () {
    [$euro, $dollar] = Currency::factory()
        ->count(2)
        ->state(new Sequence(
            ['code' => 'EUR'],
            ['code' => 'USD'],
        ))->create();

    $this->login()
        ->get(route('admin.currencies.index', ['sort' => '-code']))
        ->assertSuccessful()
        ->assertViewIs('admin.currencies.index')
        ->assertViewHas('currencies')
        ->assertSeeInOrder([$dollar->code, $euro->code]);
});

test('admin can sort currencies by rate ascending', function () {
    [$dollar, $euro] = Currency::factory()
        ->count(2)
        ->state(new Sequence(
            ['rate' => 30.0000],
            ['rate' => 28.0000],
        ))->create();

    $this->login()
        ->get(route('admin.currencies.index', ['sort' => 'rate']))
        ->assertSuccessful()
        ->assertViewIs('admin.currencies.index')
        ->assertViewHas('currencies')
        ->assertSeeInOrder([$euro->rate, $dollar->rate]);
});

test('admin can sort currencies by rate descending', function () {
    [$dollar, $euro] = Currency::factory()
        ->count(2)
        ->state(new Sequence(
            ['rate' => 30.0000],
            ['rate' => 28.0000],
        ))->create();

    $this->login()
        ->get(route('admin.currencies.index', ['sort' => '-rate']))
        ->assertSuccessful()
        ->assertViewIs('admin.currencies.index')
        ->assertViewHas('currencies')
        ->assertSeeInOrder([$dollar->rate, $euro->rate]);
});
