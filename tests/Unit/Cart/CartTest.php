<?php

namespace Tests\Unit\Cart;

use App\Models\Brand;
use App\Models\Currency;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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

        $this->product = Product::factory()
            ->hasAttached(Image::factory(), ['is_default' => 1])
            ->create();
    }

    /** @test */
    public function it_can_add()
    {
        $item = Cart::add($this->product);

        $this->assertEquals($item->id, $this->product->id);
        $this->assertEquals($item->slug, $this->product->slug);
        $this->assertEquals($item->name, $this->product->name);
        $this->assertEquals($item->category, $this->product->category->name);
        $this->assertEquals($item->price, $this->product->uah_price);
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
        $currency = Currency::factory()->state(['rate' => 30.0000]);
        $brand = Brand::factory()->for($currency);

        $generator = Product::factory()
            ->for($brand)
            ->hasAttached(Image::factory(), ['is_default' => 1])
            ->create(['price' => 10000]);

        $waterPump = Product::factory()
            ->for($brand)
            ->hasAttached(Image::factory(), ['is_default' => 1])
            ->create(['price' => 10000]);

        Cart::add($generator, 2);
        Cart::add($waterPump);

        $this->assertEquals(9000, Cart::total());
    }

    /** @test */
    public function it_can_be_cleared()
    {
        Cart::add($this->product);

        $this->assertCount(1, Cart::items());

        Cart::clear();

        $this->assertCount(0, Cart::items());
    }

    /** @test */
    public function it_can_be_stored()
    {
        $order = Order::factory()->create();

        Cart::add($this->product, $quantity = $this->faker->randomDigitNotNull);

        $this->assertDatabaseCount('order_product', 0);

        Cart::store($order);

        $this->assertDatabaseHas('order_product', [
            'product_id' => $this->product->id,
            'order_id' => $order->id,
            'quantity' => $quantity,
        ]);
    }
}
