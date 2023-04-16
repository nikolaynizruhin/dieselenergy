<?php

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant search products', function () {
    $product = Product::factory()->create();

    $this->get(route('admin.products.index', ['search' => $product->name]))
        ->assertRedirect(route('admin.login'));
});

test('user can search products', function () {
    [$diesel, $patrol, $waterPump] = Product::factory()
        ->count(3)
        ->state(new Sequence(
            ['name' => 'Diesel Generator'],
            ['name' => 'Patrol Generator'],
            ['name' => 'Water Pump'],
        ))->create();

    $this->login()
        ->get(route('admin.products.index', ['search' => 'Generator']))
        ->assertSeeInOrder([$diesel->name, $patrol->name])
        ->assertDontSee($waterPump->name);
});
