<?php

namespace Tests\Feature\Cart;

use App\Models\Product;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_add_product_to_cart()
    {
        $product = Product::factory()->withDefaultImage()->create();

        $this->from(route('categories.products.index', $product->category))
            ->post(route('carts.store', ['product_id' => $product->id, 'quantity' => 2]))
            ->assertRedirect(route('carts.index'))
            ->assertSessionHas('cart');

        $this->assertCount(1, $items = Cart::items());
        $this->assertEquals($product->id, $items->first()->id);
        $this->assertEquals(2, $items->first()->quantity);
    }

    /** @test */
    public function guest_cant_create_cart_without_product()
    {
        $this->post(route('carts.store', ['quantity' => 1]))
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function guest_cant_create_cart_with_string_product()
    {
        $this->post(route('carts.store', ['product_id' => 'string', 'quantity' => 1]))
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function guest_cant_create_cart_with_nonexistent_product()
    {
        $this->post(route('carts.store', ['product_id' => 10, 'quantity' => 1]))
            ->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function guest_cant_create_cart_without_quantity()
    {
        $product = Product::factory()->create();

        $this->post(route('carts.store', ['product_id' => $product->id]))
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_create_cart_with_string_quantity()
    {
        $product = Product::factory()->create();

        $this->post(route('carts.store', ['product_id' => $product->id, 'quantity' => 'string']))
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function guest_cant_create_cart_with_zero_quantity()
    {
        $product = Product::factory()->create();

        $this->post(route('carts.store', ['product_id' => $product->id, 'quantity' => 0]))
            ->assertSessionHasErrors('quantity');
    }
}
