<?php

namespace Tests\Feature\Admin\Order;

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

        $this->delete(route('admin.orders.destroy', $order))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_order()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();

        $this->actingAs($user)
            ->from(route('admin.orders.index'))
            ->delete(route('admin.orders.destroy', $order))
            ->assertRedirect(route('admin.orders.index'))
            ->assertSessionHas('status', 'Order was deleted successfully!');

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
