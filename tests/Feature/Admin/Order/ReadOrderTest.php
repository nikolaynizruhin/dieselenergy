<?php

namespace Tests\Feature\Admin\Order;

use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_order()
    {
        $order = factory(Order::class)->create();

        $this->get(route('admin.orders.show', $order))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_order()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();

        $this->actingAs($user)
            ->get(route('admin.orders.show', $order))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.show')
            ->assertViewHas('order')
            ->assertSee($order->status);
    }
}
