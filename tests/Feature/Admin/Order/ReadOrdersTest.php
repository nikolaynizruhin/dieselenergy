<?php

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant read orders', function () {
    $this->get(route('admin.orders.index'))
        ->assertRedirect(route('admin.login'));
});

test('user can read orders', function () {
    [$orderB, $orderA] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['created_at' => now()->subDay()],
            ['created_at' => now()],
        ))->create();

    $this->login()
        ->get(route('admin.orders.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.index')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$orderA->id, $orderB->id]);
});
