<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use Tests\TestCase;

class ReadOrderTest extends TestCase
{
    /** @test */
    public function guest_can_read_order()
    {
        $order = Order::factory()->create();

        $this->get(route('orders.show', $order))
            ->assertSuccessful()
            ->assertViewIs('orders.show')
            ->assertViewHas('order');
    }
}
