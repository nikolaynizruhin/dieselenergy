<?php

namespace Tests\Feature\Cart;

use App\Cart;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCartTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_cart_page()
    {
        $this->get(route('carts.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_create_cart_page()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();

        $this->actingAs($user)
            ->get(route('carts.create', ['order_id' => $order->id]))
            ->assertViewIs('carts.create');
    }

    /** @test */
    public function guest_cant_create_cart()
    {
        $cart = factory(Cart::class)->raw();

        $this->post(route('carts.store'), $cart)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_create_cart()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->raw();

        $this->actingAs($user)
            ->post(route('carts.store'), $cart)
            ->assertRedirect(route('orders.show', $cart['order_id']))
            ->assertSessionHas('status', 'Product was attached successfully!');

        $this->assertDatabaseHas('order_product', $cart);
    }

    /** @test */
    public function user_cant_create_cart_without_order()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->raw(['order_id' => null]);

        $this->actingAs($user)
            ->post(route('carts.store'), $cart)
            ->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_create_cart_with_string_order()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->raw(['order_id' => 'string']);

        $this->actingAs($user)
            ->post(route('carts.store'), $cart)
            ->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_create_cart_with_nonexistent_order()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->raw(['order_id' => 10]);

        $this->actingAs($user)
            ->post(route('carts.store'), $cart)
            ->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_create_cart_without_product()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->raw(['product_id' => null]);

        $this->actingAs($user)
            ->post(route('carts.store'), $cart)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_cart_with_string_product()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->raw(['product_id' => 'string']);

        $this->actingAs($user)
            ->post(route('carts.store'), $cart)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_cart_with_nonexistent_product()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->raw(['product_id' => 10]);

        $this->actingAs($user)
            ->post(route('carts.store'), $cart)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_existing_cart()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->create();

        $this->actingAs($user)
            ->post(route('carts.store'), $cart->toArray())
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_cart_without_quantity()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->raw(['quantity' => null]);

        $this->actingAs($user)
            ->post(route('carts.store'), $cart)
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_create_cart_with_string_quantity()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->raw(['quantity' => 'string']);

        $this->actingAs($user)
            ->post(route('carts.store'), $cart)
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_create_cart_with_zero_quantity()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->raw(['quantity' => 0]);

        $this->actingAs($user)
            ->post(route('carts.store'), $cart)
            ->assertSessionHasErrors('quantity');
    }
}
