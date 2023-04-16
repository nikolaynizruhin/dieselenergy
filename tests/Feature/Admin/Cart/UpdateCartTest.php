<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Cart;

beforeEach(function () {
    $this->cart = Cart::factory()->create();
});

test('guest cant visit update cart page', function () {
    $this->get(route('admin.carts.edit', $this->cart))
        ->assertRedirect(route('admin.login'));
});

test('user can visit update cart page', function () {
    $this->login()
        ->get(route('admin.carts.edit', $this->cart))
        ->assertSuccessful()
        ->assertViewIs('admin.carts.edit')
        ->assertViewHas(['cart', 'products']);
});

test('guest cant update cart', function () {
    $this->put(route('admin.carts.update', $this->cart), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can update cart', function () {
    $this->login()
        ->put(route('admin.carts.update', $this->cart), $fields = validFields())
        ->assertRedirect(route('admin.orders.show', $fields['order_id']))
        ->assertSessionHas('status', trans('cart.updated'));

    $this->assertDatabaseHas('order_product', $fields);
});

test('user cant update cart with invalid data', function (string $field, callable $data, int $count = 1) {
    $this->login()
        ->from(route('admin.carts.edit', $this->cart))
        ->put(route('admin.carts.update', $this->cart), $data())
        ->assertRedirect(route('admin.carts.edit', $this->cart))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('order_product', $count);
})->with('update_cart');
