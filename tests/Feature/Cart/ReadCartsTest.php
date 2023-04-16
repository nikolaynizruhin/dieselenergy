<?php

use App\Models\Product;
use Facades\App\Services\Cart;

test('guest can read carts', function () {
    $product = Product::factory()->withDefaultImage()->create();

    Cart::add($product);

    $this->get(route('carts.index'))
        ->assertSuccessful()
        ->assertSee($product->name);
});
