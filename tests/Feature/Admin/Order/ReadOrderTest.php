<?php

use App\Models\Order;

test('guest cant read order', function () {
    $order = Order::factory()->create();

    $this->get(route('admin.orders.show', $order))
        ->assertRedirect(route('admin.login'));
});

test('user can read order', function () {
    $order = Order::factory()->create();

    $this->login()
        ->get(route('admin.orders.show', $order))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.show')
        ->assertViewHas('order')
        ->assertSee($order->status->value)
        ->assertSee($order->customer->name);
});
