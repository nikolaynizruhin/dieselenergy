<?php

namespace Tests\Feature\Order;

use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_order()
    {
        $order = factory(Order::class)->create();

        $this->get(route('orders.show', $order))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_read_order()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();

        $this->actingAs($user)
            ->get(route('orders.show', $order))
            ->assertSuccessful()
            ->assertViewIs('orders.show')
            ->assertViewHas('order')
            ->assertSee($order->total);
    }
}
