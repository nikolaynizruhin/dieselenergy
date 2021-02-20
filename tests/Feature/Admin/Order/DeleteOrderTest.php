<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_order()
    {
        $order = Order::factory()->create();

        $this->delete(route('admin.orders.destroy', $order))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_order()
    {

        $order = Order::factory()->create();

        $this->login()
            ->from(route('admin.orders.index'))
            ->delete(route('admin.orders.destroy', $order))
            ->assertRedirect(route('admin.orders.index'))
            ->assertSessionHas('status', trans('order.deleted'));

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
