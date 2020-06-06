<?php

namespace Tests\Feature\Admin\Order;

use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_orders()
    {
        $this->get(route('admin.orders.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_orders()
    {
        $user = factory(User::class)->create();

        [$orderA, $orderB] = factory(Order::class, 2)->create();

        $this->actingAs($user)
            ->get(route('admin.orders.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSee($orderA->status)
            ->assertSee($orderB->status);
    }
}
