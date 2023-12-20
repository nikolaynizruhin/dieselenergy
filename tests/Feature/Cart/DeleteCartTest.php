<?php

use App\Models\Product;
use Facades\App\Services\Cart;

test('guest can delete cart item', function () {
    $product = Product::factory()->withDefaultImage()->create();

    Cart::add($product);

    $this->fromRoute('carts.index')
        ->delete(route('carts.destroy', 0))
        ->assertRedirect(route('carts.index'));

    expect(Cart::items())->toHaveCount(0);
});
