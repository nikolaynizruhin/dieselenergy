<?php

namespace Tests\Unit;

use App\Product;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_add()
    {
        $product = factory(Product::class)->create();

        $item = Cart::add($product);

        $this->assertEquals($item->id, $product->id);
        $this->assertEquals($item->name, $product->name);
        $this->assertEquals($item->category, $product->category->name);
        $this->assertEquals($item->price, $product->price);
        $this->assertEquals(1, $item->quantity);
    }

    /** @test */
    public function it_can_add_existing_product()
    {
        $product = factory(Product::class)->create();

        $item = Cart::add($product);

        $this->assertEquals(1, $item->quantity);

        $item = Cart::add($product);

        $this->assertEquals(2, $item->quantity);
    }

    /** @test */
    public function it_can_remove()
    {
        $product = factory(Product::class)->create();

        Cart::add($product);

        $this->assertCount(1, Cart::items());

        Cart::delete(0);

        $this->assertCount(0, Cart::items());
    }

    /** @test */
    public function it_can_get_items()
    {
        $product = factory(Product::class)->create();

        $item = Cart::add($product);

        $this->assertTrue(Cart::items()->contains($item));
    }
}
