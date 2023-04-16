<?php

use App\Models\Cart;

beforeEach(function () {
    $this->cart = Cart::factory()->create();
});

test('guest cant delete cart', function () {
    $this->delete(route('admin.carts.destroy', $this->cart))
        ->assertRedirect(route('admin.login'));
});

test('user can delete cart', function () {
    $this->login()
        ->from(route('admin.orders.show', $this->cart->order))
        ->delete(route('admin.carts.destroy', $this->cart))
        ->assertRedirect(route('admin.orders.show', $this->cart->order))
        ->assertSessionHas('status', trans('cart.deleted'));

    $this->assertModelMissing($this->cart);
});
