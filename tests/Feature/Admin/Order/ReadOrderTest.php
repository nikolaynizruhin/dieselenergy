<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use Tests\TestCase;

class ReadOrderTest extends TestCase
{
    /** @test */
    public function guest_cant_read_order()
    {
        $order = Order::factory()->create();

        $this->get(route('admin.orders.show', $order))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_order()
    {
        $order = Order::factory()->create();

        $this->login()
            ->get(route('admin.orders.show', $order))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.show')
            ->assertViewHas('order')
            ->assertSee($order->status->value)
            ->assertSee($order->customer->name);
    }
}
