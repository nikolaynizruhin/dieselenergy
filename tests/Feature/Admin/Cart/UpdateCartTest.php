<?php

namespace Tests\Feature\Admin\Cart;

use App\Cart;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCartTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_cart_page()
    {
        $cart = factory(Cart::class)->create();

        $this->get(route('admin.carts.edit', $cart))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_cart_page()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->create();

        $this->actingAs($user)
            ->get(route('admin.carts.edit', $cart))
            ->assertSuccessful()
            ->assertViewIs('admin.carts.edit')
            ->assertViewHas(['cart', 'products']);
    }

    /** @test */
    public function guest_cant_update_cart()
    {
        $cart = factory(Cart::class)->create();
        $stub = factory(Cart::class)->raw();

        $this->put(route('admin.carts.update', $cart), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_cart()
    {
        $user = factory(User::class)->create();

        $cart = factory(Cart::class)->create();
        $stub = factory(Cart::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertRedirect(route('admin.orders.show', $stub['order_id']))
            ->assertSessionHas('status', 'Cart was updated successfully!');

        $this->assertDatabaseHas('order_product', $stub);
    }

    /** @test */
    public function user_cant_update_cart_without_order()
    {
        $user = factory(User::class)->create();

        $cart = factory(Cart::class)->create();
        $stub = factory(Cart::class)->raw(['order_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_update_cart_with_string_order()
    {
        $user = factory(User::class)->create();

        $cart = factory(Cart::class)->create();
        $stub = factory(Cart::class)->raw(['order_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_update_cart_with_nonexistent_order()
    {
        $user = factory(User::class)->create();

        $cart = factory(Cart::class)->create();
        $stub = factory(Cart::class)->raw(['order_id' => 10]);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_update_cart_without_product()
    {
        $user = factory(User::class)->create();

        $cart = factory(Cart::class)->create();
        $stub = factory(Cart::class)->raw(['product_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_cart_with_string_product()
    {
        $user = factory(User::class)->create();

        $cart = factory(Cart::class)->create();
        $stub = factory(Cart::class)->raw(['product_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_cart_with_nonexistent_product()
    {
        $user = factory(User::class)->create();

        $cart = factory(Cart::class)->create();
        $stub = factory(Cart::class)->raw(['product_id' => 10]);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_existing_cart()
    {
        $user = factory(User::class)->create();

        $cart = factory(Cart::class)->create();
        $existed = factory(Cart::class)->create();

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $existed->toArray())
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_cart_without_quantity()
    {
        $user = factory(User::class)->create();

        $cart = factory(Cart::class)->create();
        $stub = factory(Cart::class)->raw(['quantity' => null]);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_update_cart_with_string_quantity()
    {
        $user = factory(User::class)->create();

        $cart = factory(Cart::class)->create();
        $stub = factory(Cart::class)->raw(['quantity' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_update_cart_with_zero_quantity()
    {
        $user = factory(User::class)->create();

        $cart = factory(Cart::class)->create();
        $stub = factory(Cart::class)->raw(['quantity' => 0]);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('quantity');
    }
}
