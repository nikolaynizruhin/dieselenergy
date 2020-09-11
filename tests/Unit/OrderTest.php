<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
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
        $customer = Customer::factory()->create();
        $order = Order::factory()->create(['customer_id' => $customer->id]);

        $this->assertInstanceOf(Customer::class, $order->customer);
        $this->assertTrue($order->customer->is($customer));
    }

    /** @test */
    public function it_has_many_products()
    {
        $product = Product::factory()->create();
        $order = Order::factory()->create();

        $order->products()->attach($product, ['quantity' => $quantity = $this->faker->randomDigit]);

        $this->assertTrue($order->products->contains($product));
        $this->assertInstanceOf(Collection::class, $order->products);
        $this->assertEquals($quantity, $order->products->first()->pivot->quantity);
    }

    /** @test */
    public function it_calculates_total_after_adding_product()
    {
        $order = Order::factory()->create(['total' => 0]);
        $product = Product::factory()->create(['price' => 100]);

        $order->products()->attach($product, ['quantity' => 3]);

        $this->assertEquals(300, $order->fresh()->total);
    }

    /** @test */
    public function it_calculates_total_after_removing_product()
    {
        $cart = Cart::factory()->create();

        $this->assertGreaterThan(0, $cart->order->total);

        $cart->order->products()->detach($cart->product);

        $this->assertEquals(0, $cart->order->fresh()->total);
    }
}
