<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant read dashboard', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('admin.login'));
});

test('user can read dashboard', function () {
    $product = Product::factory()->create();

    [$orderA, $orderB] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['created_at' => now()],
            ['created_at' => now()->subDay()],
        ))->create();

    $orderA->products()->attach($product, ['quantity' => 2]);

    $this->login()
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertViewIs('admin.dashboard')
        ->assertViewHas('orders')
        ->assertViewHas('totalCustomers', 2)
        ->assertViewHas('soldProducts', 2)
        ->assertSeeInOrder([$orderA->id, $orderB->id]);
});
