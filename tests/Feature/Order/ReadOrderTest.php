<?php

use App\Models\Order;

test('guest can read order', function () {
    $order = Order::factory()->create();

    $this->get(route('orders.show', $order))
        ->assertSuccessful()
        ->assertViewIs('orders.show')
        ->assertViewHas('order');
});
