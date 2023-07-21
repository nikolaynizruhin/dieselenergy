<?php

use App\Models\Product;
use Facades\App\Services\Cart;

test('guest can add product to cart', function () {
    $product = Product::factory()->withDefaultImage()->create();

    $this->from(route('categories.products.index', $product->category))
        ->post(route('carts.store', ['product_id' => $product->id, 'quantity' => 2]))
        ->assertRedirect(route('carts.index'))
        ->assertSessionHas('cart');

    expect($items = Cart::items())->toHaveCount(1);
    expect($items->first()->id)->toEqual($product->id);
    expect($items->first()->quantity)->toEqual(2);
});

test('guest cant create cart with invalid data', function (string $field, callable $data) {
    $this->post(route('carts.store', $data()))
        ->assertInvalid($field);

    expect(Cart::items())->toBeEmpty();
})->with([
    'Product is required' => [
        'product_id', fn () => ['product_id' => null, 'quantity' => 1],
    ],
    'Product cant be a string' => [
        'product_id', fn () => ['product_id' => 'string', 'quantity' => 1],
    ],
    'Product must exists' => [
        'product_id', fn () => ['product_id' => 10, 'quantity' => 1],
    ],
    'Quantity is required' => [
        'quantity', fn () => ['product_id' => Product::factory()->create()->id, 'quantity' => null],
    ],
    'Quantity cant be a string' => [
        'quantity', fn () => ['product_id' => Product::factory()->create()->id, 'quantity' => 'string'],
    ],
    'Quantity cant be zero' => [
        'quantity', fn () => ['product_id' => Product::factory()->create()->id, 'quantity' => 0],
    ],
]);
