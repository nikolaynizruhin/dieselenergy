<?php

namespace Tests\Unit;

use App\Customer;
use App\Order;
use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_has_customer()
    {
        $customer = factory(Customer::class)->create();
        $order = factory(Order::class)->create(['customer_id' => $customer->id]);

        $this->assertInstanceOf(Customer::class, $order->customer);
        $this->assertTrue($order->customer->is($customer));
    }

    /** @test */
    public function it_has_many_products()
    {
        $product = factory(Product::class)->create();
        $order = factory(Order::class)->create();

        $order->products()->attach($product, ['quantity' => $quantity = $this->faker->randomDigit]);

        $this->assertTrue($order->products->contains($product));
        $this->assertInstanceOf(Collection::class, $order->products);
        $this->assertEquals($quantity, $order->products->first()->pivot->quantity);
    }
}
