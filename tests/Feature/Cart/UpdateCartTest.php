<?php

namespace Tests\Feature\Cart;

use App\Image;
use App\Product;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_update_cart()
    {
        $image = factory(Image::class)->create();
        $product = factory(Product::class)->create();

        $product->images()->attach($image, ['is_default' => 1]);

        Cart::add($product, 1);

        $this->put(route('carts.update', ['cart' => 0, 'quantity' => 3]))
            ->assertRedirect(route('carts.index'))
            ->assertSessionHas('cart')
            ->assertSessionHas('status', trans('carts.updated'));

        $this->assertCount(1, $items = Cart::items());
        $this->assertEquals($product->id, $items->first()->id);
        $this->assertEquals(3, $items->first()->quantity);
    }

    /** @test */
    public function guest_cant_create_cart_without_quantity()
    {
        $image = factory(Image::class)->create();
        $product = factory(Product::class)->create();

        $product->images()->attach($image, ['is_default' => 1]);

        Cart::add($product, 1);

        $this->put(route('carts.update', 0))
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function user_cant_update_cart_with_string_quantity()
    {
        $image = factory(Image::class)->create();
        $product = factory(Product::class)->create();

        $product->images()->attach($image, ['is_default' => 1]);

        Cart::add($product, 1);

        $this->put(route('carts.update', ['cart' => 0, 'quantity' => 'string']))
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function guest_cant_update_cart_with_zero_quantity()
    {
        $image = factory(Image::class)->create();
        $product = factory(Product::class)->create();

        $product->images()->attach($image, ['is_default' => 1]);

        Cart::add($product, 1);

        $this->put(route('carts.update', ['cart' => 0, 'quantity' => 0]))
            ->assertSessionHasErrors('quantity');
    }
}
