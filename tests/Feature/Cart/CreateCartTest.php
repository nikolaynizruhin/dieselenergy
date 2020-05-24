<?php

namespace Tests\Feature\Cart;

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
        $order = factory(Order::class)->create();
        $product = factory(Product::class)->create();

        $this->post(route('carts.store'), [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $this->faker->randomDigit,
        ])->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_create_cart()
    {
        $user = factory(User::class)->create();

        $order = factory(Order::class)->create();
        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->post(route('carts.store'), [
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $this->faker->randomDigit,
            ])->assertRedirect(route('orders.show', $order))
            ->assertSessionHas('status', 'Product was attached successfully!');

        $id = $order->fresh()->products()->find($product->id)->pivot->id;

        $this->assertDatabaseHas('order_product', ['id' => $id]);
    }

    /** @test */
    public function user_cant_create_cart_without_order()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->post(route('carts.store'), [
                'product_id' => $product->id,
                'quantity' => $this->faker->randomDigit,
            ])->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_create_cart_with_string_order()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->post(route('carts.store'), [
                'order_id' => 'string',
                'product_id' => $product->id,
                'quantity' => $this->faker->randomDigit,
            ])->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_create_cart_with_nonexistent_order()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->post(route('carts.store'), [
                'order_id' => 1,
                'product_id' => $product->id,
                'quantity' => $this->faker->randomDigit,
            ])->assertSessionHasErrors('order_id');
    }

    /** @test */
    public function user_cant_create_cart_without_product()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();

        $this->actingAs($user)
            ->post(route('carts.store'), [
                'order_id' => $order->id,
                'quantity' => $this->faker->randomDigit,
            ])->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_cart_with_string_product()
    {
        $user = factory(User::class)->create();

        $order = factory(Order::class)->create();

        $this->actingAs($user)
            ->post(route('carts.store'), [
                'order_id' => $order->id,
                'product_id' => 'string',
                'quantity' => $this->faker->randomDigit,
            ])->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_cart_with_nonexistent_product()
    {
        $user = factory(User::class)->create();

        $order = factory(Order::class)->create();

        $this->actingAs($user)
            ->post(route('carts.store'), [
                'order_id' => $order->id,
                'product_id' => 1,
                'quantity' => $this->faker->randomDigit,
            ])->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_existing_cart()
    {
        $user = factory(User::class)->create();

        $order = factory(Order::class)->create();
        $product = factory(Product::class)->create();

        $order->products()->attach($product);

        $this->actingAs($user)
            ->post(route('carts.store'), [
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $this->faker->randomDigit,
            ])->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_cant_create_cart_without_quantity()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->post(route('carts.store'), [
                'order_id' => $order->id,
                'product_id' => $product->id,
            ])->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_create_cart_with_string_quantity()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->post(route('carts.store'), [
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 'string',
            ])->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_create_cart_with_zero_quantity()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->post(route('carts.store'), [
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 0,
            ])->assertSessionHasErrors('quantity');
    }
}
