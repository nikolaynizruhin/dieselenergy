<?php

namespace Tests\Feature\Order;

use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_order()
    {
        $order = factory(Order::class)->create();

        $this->delete(route('orders.destroy', $order))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_delete_order()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();

        $this->actingAs($user)
            ->from(route('orders.index'))
            ->delete(route('orders.destroy', $order))
            ->assertRedirect(route('orders.index'))
            ->assertSessionHas('status', 'Order was deleted successfully!');

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
