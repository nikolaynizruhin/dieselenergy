<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadOrderTest extends TestCase
{
    use RefreshDatabase;

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
            ->assertSee($order->status)
            ->assertSee($order->customer->name);
    }
}
