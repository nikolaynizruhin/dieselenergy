<?php

namespace Tests\Unit;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{


    /** @test */
    public function it_has_many_orders()
    {
        $customer = Customer::factory()
            ->hasOrders(1)
            ->create();

        $this->assertInstanceOf(Collection::class, $customer->orders);
    }
}
