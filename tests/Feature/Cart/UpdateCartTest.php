<?php

namespace Tests\Feature\Cart;

use App\Models\Product;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Product.
     *
     * @var \App\Models\Product
     */
    private $product;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->withDefaultImage()->create();

        Cart::add($this->product, 1);
    }

    /** @test */
    public function guest_can_update_cart()
    {
        $this->put(route('carts.update', ['cart' => 0, 'quantity' => 3]))
            ->assertRedirect(route('carts.index'))
            ->assertSessionHas('cart');

        $this->assertCount(1, $items = Cart::items());
        $this->assertEquals($this->product->id, $items->first()->id);
        $this->assertEquals(3, $items->first()->quantity);
    }

    /** @test */
    public function guest_cant_create_cart_without_quantity()
    {
        $this->put(route('carts.update', 0))
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_update_cart_with_string_quantity()
    {
        $this->put(route('carts.update', ['cart' => 0, 'quantity' => 'string']))
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function guest_cant_update_cart_with_zero_quantity()
    {
        $this->put(route('carts.update', ['cart' => 0, 'quantity' => 0]))
            ->assertSessionHasErrors('quantity');
    }
}
