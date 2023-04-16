<?php

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest_cant_search_brands', function () {
    $brand = Brand::factory()->create();

    $this->get(route('admin.brands.index', ['search' => $brand->name]))
        ->assertRedirect(route('admin.login'));
});

test('user_can_search_brands', function () {
    [$sdmo, $hyundai, $bosch] = Brand::factory()
        ->count(3)
        ->state(new Sequence(
            ['name' => 'SDMO Brand'],
            ['name' => 'Hyundai Brand'],
            ['name' => 'Bosch'],
        ))->create();

    $this->login()
        ->get(route('admin.brands.index', ['search' => 'Brand']))
        ->assertSeeInOrder([$hyundai->name, $sdmo->name])
        ->assertDontSee($bosch->name);
});
