<?php

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant read brands', function () {
    $this->get(route('admin.brands.index'))
        ->assertRedirect(route('admin.login'));
});

test('user can read brands', function () {
    [$sdmo, $hyundai] = Brand::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'SDMO'],
            ['name' => 'Hyundai']
        ))->create();

    $this->login()
        ->get(route('admin.brands.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.brands.index')
        ->assertViewHas('brands')
        ->assertSeeInOrder([$hyundai->name, $sdmo->name]);
});
