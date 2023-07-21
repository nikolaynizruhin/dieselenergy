<?php

use App\Models\Product;
use Facades\App\Services\Cart;

beforeEach(function () {
    $this->product = Product::factory()->withDefaultImage()->create();

    Cart::add($this->product, 1);
});

test('guest can update cart', function () {
    $this->put(route('carts.update', ['cart' => 0, 'quantity' => 3]))
        ->assertRedirect(route('carts.index'))
        ->assertSessionHas('cart');

    expect($items = Cart::items())->toHaveCount(1);
    expect($items->first()->id)->toEqual($this->product->id);
    expect($items->first()->quantity)->toEqual(3);
});

test('guest cant create cart with invalid data', function ($quantity) {
    $this->put(route('carts.update', ['cart' => 0, 'quantity' => $quantity]))
        ->assertInvalid('quantity');
})->with([
    'Quantity is required' => [null],
    'Quantity cant be a string' => ['string'],
    'Quantity cant be zero' => [0],
]);
