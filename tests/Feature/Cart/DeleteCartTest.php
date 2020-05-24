<?php

namespace Tests\Feature\Cart;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_cart()
    {
        $product = factory(Product::class)->create();
        $order = factory(Order::class)->create();

        $order->products()->attach($product);

        $id = $order->products()->find($product->id)->pivot->id;

        $this->delete(route('carts.destroy', $id))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_delete_cart()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create();
        $order = factory(Order::class)->create();

        $order->products()->attach($product);

        $id = $order->products()->find($product->id)->pivot->id;

        $this->actingAs($user)
            ->from(route('orders.show', $order))
            ->delete(route('carts.destroy', $id))
            ->assertRedirect(route('orders.show', $order))
            ->assertSessionHas('status', 'Product was detached successfully!');

        $this->assertDatabaseMissing('order_product', ['id' => $id]);
    }
}
