<?php


use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant search orders', function () {
    $order = Order::factory()->create();

    $this->get(route('admin.orders.index', ['search' => $order->id]))
        ->assertRedirect(route('admin.login'));
});

test('user can search orders', function () {
    [$orderA, $orderB, $orderC] = Order::factory()
        ->count(3)
        ->state(new Sequence(
            ['id' => 70613, 'created_at' => now()->subDay()],
            ['id' => 70614],
            ['id' => 70625],
        ))->create();

    $this->login()
        ->get(route('admin.orders.index', ['search' => '7061']))
        ->assertSeeInOrder([$orderB->id, $orderA->id])
        ->assertDontSee($orderC->id);
});
