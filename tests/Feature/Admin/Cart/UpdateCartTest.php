<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCartTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_cart_page()
    {
        $cart = Cart::factory()->create();

        $this->get(route('admin.carts.edit', $cart))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_cart_page()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.carts.edit', $cart))
            ->assertSuccessful()
            ->assertViewIs('admin.carts.edit')
            ->assertViewHas(['cart', 'products']);
    }

    /** @test */
    public function guest_cant_update_cart()
    {
        $cart = Cart::factory()->create();
        $stub = Cart::factory()->raw();

        $this->put(route('admin.carts.update', $cart), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_cart()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create();
        $stub = Cart::factory()->raw();

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertRedirect(route('admin.orders.show', $stub['order_id']))
            ->assertSessionHas('status', trans('cart.updated'));

        $this->assertDatabaseHas('order_product', $stub);
    }

    /** @test */
    public function user_cant_update_cart_without_order()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create();
        $stub = Cart::factory()->raw(['order_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_update_cart_with_string_order()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create();
        $stub = Cart::factory()->raw(['order_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_update_cart_with_nonexistent_order()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create();
        $stub = Cart::factory()->raw(['order_id' => 10]);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_update_cart_without_product()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create();
        $stub = Cart::factory()->raw(['product_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_cart_with_string_product()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create();
        $stub = Cart::factory()->raw(['product_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_cart_with_nonexistent_product()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create();
        $stub = Cart::factory()->raw(['product_id' => 10]);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_existing_cart()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create();
        $existed = Cart::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $existed->toArray())
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_update_cart_without_quantity()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create();
        $stub = Cart::factory()->raw(['quantity' => null]);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_update_cart_with_string_quantity()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create();
        $stub = Cart::factory()->raw(['quantity' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_update_cart_with_zero_quantity()
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create();
        $stub = Cart::factory()->raw(['quantity' => 0]);

        $this->actingAs($user)
            ->put(route('admin.carts.update', $cart), $stub)
            ->assertSessionHasErrors('quantity');
    }
}
