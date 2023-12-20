<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Order;

test('guest cant visit create cart page', function () {
    $order = Order::factory()->create();

    $this->get(route('admin.carts.create', ['order_id' => $order->id]))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create cart page', function () {
    $order = Order::factory()->create();

    $this->login()
        ->get(route('admin.carts.create', ['order_id' => $order->id]))
        ->assertViewIs('admin.carts.create');
});

test('guest cant create cart', function () {
    $this->post(route('admin.carts.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create cart', function () {
    $this->login()
        ->post(route('admin.carts.store'), $fields = validFields())
        ->assertRedirect(route('admin.orders.show', $fields['order_id']))
        ->assertSessionHas('status', trans('cart.created'));

    $this->assertDatabaseHas('order_product', $fields);
});

test('user cant create cart with invalid data', function (string $field, callable $data, int $count = 0) {
    $this->login()
        ->fromRoute('admin.carts.create')
        ->post(route('admin.carts.store'), $data())
        ->assertRedirect(route('admin.carts.create'))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('order_product', $count);
})->with('create_cart');
