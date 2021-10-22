<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCartTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function guest_cant_visit_create_cart_page()
    {
        $this->get(route('admin.carts.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_cart_page()
    {
        $order = Order::factory()->create();

        $this->login()
            ->get(route('admin.carts.create', ['order_id' => $order->id]))
            ->assertViewIs('admin.carts.create');
    }

    /** @test */
    public function guest_cant_create_cart()
    {
        $cart = Cart::factory()->raw();

        $this->post(route('admin.carts.store'), $cart)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_cart()
    {
        $cart = Cart::factory()->raw();

        $this->login()
            ->post(route('admin.carts.store'), $cart)
            ->assertRedirect(route('admin.orders.show', $cart['order_id']))
            ->assertSessionHas('status', trans('cart.created'));

        $this->assertDatabaseHas('order_product', $cart);
    }

    /** @test */
    public function user_cant_create_cart_without_order()
    {
        $cart = Cart::factory()->raw(['order_id' => null]);

        $this->login()
            ->from(route('admin.carts.create'))
            ->post(route('admin.carts.store'), $cart)
            ->assertRedirect(route('admin.carts.create'))
            ->assertSessionHasErrors('order_id');

        $this->assertDatabaseCount('order_product', 0);
    }

    /** @test */
    public function user_cant_create_cart_with_string_order()
    {
        $cart = Cart::factory()->raw(['order_id' => 'string']);

        $this->login()
            ->from(route('admin.carts.create'))
            ->post(route('admin.carts.store'), $cart)
            ->assertRedirect(route('admin.carts.create'))
            ->assertSessionHasErrors('order_id');

        $this->assertDatabaseCount('order_product', 0);
    }

    /** @test */
    public function user_cant_create_cart_with_nonexistent_order()
    {
        $cart = Cart::factory()->raw(['order_id' => 10]);

        $this->login()
            ->from(route('admin.carts.create'))
            ->post(route('admin.carts.store'), $cart)
            ->assertRedirect(route('admin.carts.create'))
            ->assertSessionHasErrors('order_id');

        $this->assertDatabaseCount('order_product', 0);
    }

    /** @test */
    public function user_cant_create_cart_without_product()
    {
        $cart = Cart::factory()->raw(['product_id' => null]);

        $this->login()
            ->from(route('admin.carts.create'))
            ->post(route('admin.carts.store'), $cart)
            ->assertRedirect(route('admin.carts.create'))
            ->assertSessionHasErrors('product_id');

        $this->assertDatabaseCount('order_product', 0);
    }

    /** @test */
    public function user_cant_create_cart_with_string_product()
    {
        $cart = Cart::factory()->raw(['product_id' => 'string']);

        $this->login()
            ->from(route('admin.carts.create'))
            ->post(route('admin.carts.store'), $cart)
            ->assertRedirect(route('admin.carts.create'))
            ->assertSessionHasErrors('product_id');

        $this->assertDatabaseCount('order_product', 0);
    }

    /** @test */
    public function user_cant_create_cart_with_nonexistent_product()
    {
        $cart = Cart::factory()->raw(['product_id' => 10]);

        $this->login()
            ->from(route('admin.carts.create'))
            ->post(route('admin.carts.store'), $cart)
            ->assertRedirect(route('admin.carts.create'))
            ->assertSessionHasErrors('product_id');

        $this->assertDatabaseCount('order_product', 0);
    }

    /** @test */
    public function user_cant_create_existing_cart()
    {
        $cart = Cart::factory()->create();

        $this->login()
            ->from(route('admin.carts.create'))
            ->post(route('admin.carts.store'), $cart->toArray())
            ->assertRedirect(route('admin.carts.create'))
            ->assertSessionHasErrors('product_id');

        $this->assertDatabaseCount('order_product', 1);
    }

    /** @test */
    public function user_cant_create_cart_without_quantity()
    {
        $cart = Cart::factory()->raw(['quantity' => null]);

        $this->login()
            ->from(route('admin.carts.create'))
            ->post(route('admin.carts.store'), $cart)
            ->assertRedirect(route('admin.carts.create'))
            ->assertSessionHasErrors('quantity');

        $this->assertDatabaseCount('order_product', 0);
    }

    /** @test */
    public function user_cant_create_cart_with_string_quantity()
    {
        $cart = Cart::factory()->raw(['quantity' => 'string']);

        $this->login()
            ->from(route('admin.carts.create'))
            ->post(route('admin.carts.store'), $cart)
            ->assertRedirect(route('admin.carts.create'))
            ->assertSessionHasErrors('quantity');

        $this->assertDatabaseCount('order_product', 0);
    }

    /** @test */
    public function user_cant_create_cart_with_zero_quantity()
    {
        $cart = Cart::factory()->raw(['quantity' => 0]);

        $this->login()
            ->from(route('admin.carts.create'))
            ->post(route('admin.carts.store'), $cart)
            ->assertRedirect(route('admin.carts.create'))
            ->assertSessionHasErrors('quantity');

        $this->assertDatabaseCount('order_product', 0);
    }
}
