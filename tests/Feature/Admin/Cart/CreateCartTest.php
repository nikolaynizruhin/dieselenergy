<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCartTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_cart_page()
    {
        $this->get(route('admin.carts.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_cart_page()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();

        $this->actingAs($user)
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
        $user = User::factory()->create();
        $cart = Cart::factory()->raw();

        $this->actingAs($user)
            ->post(route('admin.carts.store'), $cart)
            ->assertRedirect(route('admin.orders.show', $cart['order_id']))
            ->assertSessionHas('status', trans('cart.created'));

        $this->assertDatabaseHas('order_product', $cart);
    }

    /** @test */
    public function user_cant_create_cart_without_order()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->raw(['order_id' => null]);

        $this->actingAs($user)
            ->post(route('admin.carts.store'), $cart)
            ->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_create_cart_with_string_order()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->raw(['order_id' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.carts.store'), $cart)
            ->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_create_cart_with_nonexistent_order()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->raw(['order_id' => 10]);

        $this->actingAs($user)
            ->post(route('admin.carts.store'), $cart)
            ->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_create_cart_without_product()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->raw(['product_id' => null]);

        $this->actingAs($user)
            ->post(route('admin.carts.store'), $cart)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_cart_with_string_product()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->raw(['product_id' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.carts.store'), $cart)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_cart_with_nonexistent_product()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->raw(['product_id' => 10]);

        $this->actingAs($user)
            ->post(route('admin.carts.store'), $cart)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_existing_cart()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.carts.store'), $cart->toArray())
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_cart_without_quantity()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->raw(['quantity' => null]);

        $this->actingAs($user)
            ->post(route('admin.carts.store'), $cart)
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_create_cart_with_string_quantity()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->raw(['quantity' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.carts.store'), $cart)
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_create_cart_with_zero_quantity()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->raw(['quantity' => 0]);

        $this->actingAs($user)
            ->post(route('admin.carts.store'), $cart)
            ->assertSessionHasErrors('quantity');
    }
}
