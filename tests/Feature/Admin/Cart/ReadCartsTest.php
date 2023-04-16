<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('user can read carts', function () {
    [$patrol, $diesel] = Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Patrol'],
            ['name' => 'Diesel']
        ))->create();

    $order = Order::factory()->create();

    $order->products()->attach([
        $patrol->id => ['quantity' => fake()->randomDigit()],
        $diesel->id => ['quantity' => fake()->randomDigit()],
    ]);

    $this->login()
        ->get(route('admin.orders.show', $order))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.show')
        ->assertViewHas('products')
        ->assertSeeInOrder([$diesel->name, $patrol->name]);
});
