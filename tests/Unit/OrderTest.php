<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Currency;
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
        $order = Order::factory()
            ->for(Customer::factory())
            ->create();

        $this->assertInstanceOf(Customer::class, $order->customer);
    }

    /** @test */
    public function it_has_many_products()
    {
        $order = Order::factory()
            ->hasAttached(Product::factory(), [
                'quantity' => $quantity = $this->faker->randomDigit,
            ])->create();

        $this->assertInstanceOf(Collection::class, $order->products);
        $this->assertEquals($quantity, $order->products->first()->pivot->quantity);
    }

    /** @test */
    public function it_calculates_total_after_adding_product()
    {
        $currency = Currency::factory()->state(['rate' => 30.0000]);
        $brand = Brand::factory()->for($currency);

        $order = Order::factory()
            ->hasAttached(
                Product::factory()
                    ->for($brand)
                    ->state(fn (array $attributes, Order $order) => ['price' => 10000]),
                ['quantity' => 3],
            )->create(['total' => 0]);

        $this->assertEquals(9000, $order->fresh()->total);
    }

    /** @test */
    public function it_calculates_total_after_removing_product()
    {
        $cart = Cart::factory()->create();

        $this->assertGreaterThan(0, $cart->order->total);

        $cart->order->products()->detach($cart->product);

        $this->assertEquals(0, $cart->order->fresh()->total);
    }

    /** @test */
    public function it_has_decimal_total()
    {
        $order = Order::factory()->create(['total' => 10000]);

        $this->assertEquals(100.00, $order->decimal_total);
    }
}
