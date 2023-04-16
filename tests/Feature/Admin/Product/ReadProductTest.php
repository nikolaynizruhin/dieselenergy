<?php

use App\Models\Product;

test('guest cant read product', function () {
    $product = Product::factory()->create();

    $this->get(route('admin.products.show', $product))
        ->assertRedirect(route('admin.login'));
});

test('user can read product', function () {
    $product = Product::factory()->create();

    $this->login()
        ->get(route('admin.products.show', $product))
        ->assertSuccessful()
        ->assertViewIs('admin.products.show')
        ->assertViewHas('product')
        ->assertSee($product->name);
});
