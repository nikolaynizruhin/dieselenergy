<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_cart()
    {
        $product = Product::factory()->create();
        $order = Order::factory()->create();

        $order->products()->attach($product);

        $id = $order->products()->find($product->id)->pivot->id;

        $this->delete(route('admin.carts.destroy', $id))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_cart()
    {
        $product = Product::factory()->create();
        $order = Order::factory()->create();

        $order->products()->attach($product);

        $id = $order->products()->find($product->id)->pivot->id;

        $this->login()
            ->from(route('admin.orders.show', $order))
            ->delete(route('admin.carts.destroy', $id))
            ->assertRedirect(route('admin.orders.show', $order))
            ->assertSessionHas('status', trans('cart.deleted'));

        $this->assertDatabaseMissing('order_product', ['id' => $id]);
    }
}
