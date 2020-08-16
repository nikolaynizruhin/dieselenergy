<?php

namespace Tests\Unit\Cart;

use App\Image;
use App\Product;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_add()
    {
        $image = factory(Image::class)->create();
        $product = factory(Product::class)->create();

        $product->images()->attach($image, ['is_default' => 1]);

        $item = Cart::add($product);

        $this->assertEquals($item->id, $product->id);
        $this->assertEquals($item->name, $product->name);
        $this->assertEquals($item->category, $product->category->name);
        $this->assertEquals($item->price, $product->price);
        $this->assertEquals($item->image, $product->defaultImage()->path);
        $this->assertEquals(1, $item->quantity);
    }

    /** @test */
    public function it_can_add_existing_product()
    {
        $image = factory(Image::class)->create();
        $product = factory(Product::class)->create();

        $product->images()->attach($image, ['is_default' => 1]);

        $item = Cart::add($product, 2);

        $this->assertEquals(2, $item->quantity);

        $item = Cart::add($product, 2);

        $this->assertEquals(4, $item->quantity);
    }

    /** @test */
    public function it_can_remove()
    {
        $image = factory(Image::class)->create();
        $product = factory(Product::class)->create();

        $product->images()->attach($image, ['is_default' => 1]);

        Cart::add($product);

        $this->assertCount(1, Cart::items());

        Cart::delete(0);

        $this->assertCount(0, Cart::items());
    }

    /** @test */
    public function it_can_get_items()
    {
        $image = factory(Image::class)->create();
        $product = factory(Product::class)->create();

        $product->images()->attach($image, ['is_default' => 1]);

        $item = Cart::add($product);

        $items = Cart::items();

        $this->assertTrue($items->contains($item));
        $this->assertInstanceOf(Collection::class, $items);
    }

    /** @test */
    public function it_can_update_cart_item()
    {
        $image = factory(Image::class)->create();
        $product = factory(Product::class)->create();

        $product->images()->attach($image, ['is_default' => 1]);

        Cart::add($product);

        $item = Cart::update(0, 5);

        $this->assertEquals($product->id, $item->id);
        $this->assertEquals(5, $item->quantity);
    }

    /** @test */
    public function it_can_get_total()
    {
        $image = factory(Image::class)->create();

        $generator = factory(Product::class)->create(['price' => 100]);
        $waterPump = factory(Product::class)->create(['price' => 100]);

        $generator->images()->attach($image, ['is_default' => 1]);
        $waterPump->images()->attach($image, ['is_default' => 1]);

        Cart::add($generator, 2);
        Cart::add($waterPump);

        $this->assertEquals(300, Cart::total());
    }
}
