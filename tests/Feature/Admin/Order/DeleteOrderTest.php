<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use Tests\TestCase;

class DeleteOrderTest extends TestCase
{
    /**
     * Order.
     */
    private Order $order;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_order(): void
    {
        $this->delete(route('admin.orders.destroy', $this->order))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_order(): void
    {
        $this->login()
            ->from(route('admin.orders.index'))
            ->delete(route('admin.orders.destroy', $this->order))
            ->assertRedirect(route('admin.orders.index'))
            ->assertSessionHas('status', trans('order.deleted'));

        $this->assertModelMissing($this->order);
    }
}
