<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ReadOrdersTest extends TestCase
{
    /** @test */
    public function guest_cant_read_orders()
    {
        $this->get(route('admin.orders.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_orders()
    {
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
            ->assertSeeInOrder([$orderA->status, $orderB->status]);
    }
}
