<?php

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant read products', function () {
    $this->get(route('admin.products.index'))
        ->assertRedirect(route('admin.login'));
});

test('user can read products', function () {
    [$petrol, $diesel] = Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Petrol'],
            ['name' => 'Diesel'],
        ))->create();

    $this->login()
        ->get(route('admin.products.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.products.index')
        ->assertViewHas('products')
        ->assertSeeInOrder([$diesel->name, $petrol->name]);
});
