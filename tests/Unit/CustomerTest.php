<?php

namespace Tests\Unit;

use App\Customer;
use App\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_orders()
    {
        $customer = factory(Customer::class)->create();
        $order = factory(Order::class)->create(['customer_id' => $customer->id]);

        $this->assertTrue($customer->orders->contains($order));
        $this->assertInstanceOf(Collection::class, $customer->orders);
    }
}
