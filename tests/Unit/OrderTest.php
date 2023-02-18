<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Support\Money;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /** @test */
    public function it_has_customer(): void
    {
        $order = Order::factory()
            ->forCustomer()
            ->create();

        $this->assertInstanceOf(Customer::class, $order->customer);
    }

    /** @test */
    public function it_has_many_products(): void
    {
        $order = Order::factory()
            ->hasAttached(Product::factory(), [
                'quantity' => $quantity = fake()->randomDigit(),
            ])->create();

        $this->assertInstanceOf(Collection::class, $order->products);
        $this->assertEquals($quantity, $order->products->first()->pivot->quantity);
    }

    /** @test */
    public function it_calculates_total_after_adding_product(): void
    {
        $currency = Currency::factory()->state(['rate' => 30.0000]);
        $brand = Brand::factory()->for($currency);
        $product = Product::factory()->for($brand)->state(fn () => ['price' => 10000]);

        $order = Order::factory()
            ->hasAttached($product, ['quantity' => 3])
            ->create(['total' => 0]);

        $this->assertEquals(900000, $order->fresh()->total->coins());
    }

    /** @test */
    public function it_calculates_total_after_removing_product(): void
    {
        $cart = Cart::factory()->create();

        $this->assertGreaterThan(0, $cart->order->total->coins());

        $cart->order->products()->detach($cart->product);

        $this->assertEquals(0, $cart->order->fresh()->total->coins());
    }

    /** @test */
    public function it_has_total_as_money(): void
    {
        $order = Order::factory()->create();

        $this->assertInstanceOf(Money::class, $order->total);
    }
}
