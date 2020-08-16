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

    /**
     * Product.
     *
     * @var \App\Product
     */
    private $product;

    /**
     * Setup
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->product = factory(Product::class)->create();

        $image = factory(Image::class)->create();

        $this->product->images()->attach($image, ['is_default' => 1]);
    }

    /** @test */
    public function it_can_add()
    {
        $item = Cart::add($this->product);

        $this->assertEquals($item->id, $this->product->id);
        $this->assertEquals($item->name, $this->product->name);
        $this->assertEquals($item->category, $this->product->category->name);
        $this->assertEquals($item->price, $this->product->price);
        $this->assertEquals($item->image, $this->product->defaultImage()->path);
        $this->assertEquals(1, $item->quantity);
    }

    /** @test */
    public function it_can_add_existing_product()
    {
        $item = Cart::add($this->product, 2);

        $this->assertEquals(2, $item->quantity);

        $item = Cart::add($this->product, 2);

        $this->assertEquals(4, $item->quantity);
    }

    /** @test */
    public function it_can_remove()
    {
        Cart::add($this->product);

        $this->assertCount(1, Cart::items());

        Cart::delete(0);

        $this->assertCount(0, Cart::items());
    }

    /** @test */
    public function it_can_get_items()
    {
        $item = Cart::add($this->product);

        $items = Cart::items();

        $this->assertTrue($items->contains($item));
        $this->assertInstanceOf(Collection::class, $items);
    }

    /** @test */
    public function it_can_update_cart_item()
    {
        Cart::add($this->product);

        $item = Cart::update(0, 5);

        $this->assertEquals($this->product->id, $item->id);
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
