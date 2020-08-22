<?php

namespace Tests\Feature\Order;

use App\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_read_order()
    {
        $order = factory(Order::class)->create();

        $this->get(route('orders.show', $order))
            ->assertSuccessful()
            ->assertViewIs('orders.show')
            ->assertViewHas('order');
    }
}
