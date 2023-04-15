<?php

use App\Models\Brand;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant sort brands', function () {
    $this->get(route('admin.brands.index', ['sort' => 'name']))
        ->assertRedirect(route('admin.login'));
});

test('admin can sort brands by name ascending', function () {
    [$hyundai, $sdmo] = Brand::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Hyundai'],
            ['name' => 'SDMO'],
        ))->create();

    $this->login()
        ->get(route('admin.brands.index', ['sort' => 'name']))
        ->assertSuccessful()
        ->assertViewIs('admin.brands.index')
        ->assertViewHas('brands')
        ->assertSeeInOrder([$hyundai->name, $sdmo->name]);
});

test('admin can sort brands by name descending', function () {
    [$hyundai, $sdmo] = Brand::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Hyundai'],
            ['name' => 'SDMO'],
        ))->create();

    $this->login()
        ->get(route('admin.brands.index', ['sort' => '-name']))
        ->assertSuccessful()
        ->assertViewIs('admin.brands.index')
        ->assertViewHas('brands')
        ->assertSeeInOrder([$sdmo->name, $hyundai->name]);
});

test('admin can sort brands by currency ascending', function () {
    [$usd, $eur] = Currency::factory()
        ->count(2)
        ->state(new Sequence(
            ['code' => 'USD'],
            ['code' => 'EUR'],
        ))->create();

    Brand::factory()
        ->count(2)
        ->state(new Sequence(
            ['currency_id' => $usd],
            ['currency_id' => $eur],
        ))->create();

    $this->login()
        ->get(route('admin.brands.index', ['sort' => 'currencies.code']))
        ->assertSuccessful()
        ->assertViewIs('admin.brands.index')
        ->assertViewHas('brands')
        ->assertSeeInOrder([$eur->code, $usd->code]);
});

test('admin can sort brands by currency descending', function () {
    [$usd, $eur] = Currency::factory()
        ->count(2)
        ->state(new Sequence(
            ['code' => 'USD'],
            ['code' => 'EUR'],
        ))->create();

    Brand::factory()
        ->count(2)
        ->state(new Sequence(
            ['currency_id' => $usd],
            ['currency_id' => $eur],
        ))->create();

    $this->login()
        ->get(route('admin.brands.index', ['sort' => 'currencies.code']))
        ->assertSuccessful()
        ->assertViewIs('admin.brands.index')
        ->assertViewHas('brands')
        ->assertSeeInOrder([$eur->code, $usd->code]);
});
