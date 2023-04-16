<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant search cart', function () {
    $product = Product::factory()->create(['name' => 'Diesel Generator']);

    $order = Order::factory()->create();

    $order->products()->attach([$product->id]);

    $this->get(route('admin.orders.show', [
        'order' => $order,
        'search' => 'Diesel',
    ]))->assertRedirect(route('admin.login'));
});

test('user can search cart', function () {
    [$patrol, $diesel, $waterPump] = Product::factory()
        ->count(3)
        ->state(new Sequence(
            ['name' => 'Patrol Generator'],
            ['name' => 'Diesel Generator'],
            ['name' => 'Water Pump'],
        ))->create();

    $order = Order::factory()->create();

    $order->products()->attach([$diesel->id, $patrol->id, $waterPump->id]);

    $this->login()
        ->get(route('admin.orders.show', [
            'order' => $order,
            'search' => 'Generator',
        ]))->assertSuccessful()
        ->assertSeeInOrder([$diesel->name, $patrol->name])
        ->assertDontSee($waterPump->name);
});
