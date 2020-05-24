<?php

namespace Tests\Feature\Cart;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadCartsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function user_can_read_carts()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create();
        $order = factory(Order::class)->create();

        $order->products()->attach($product, ['quantity' => $quantity = $this->faker->randomDigit]);

        $this->actingAs($user)
            ->get(route('orders.show', $order))
            ->assertSuccessful()
            ->assertViewIs('orders.show')
            ->assertViewHas('products')
            ->assertSee($product->name);
    }
}
