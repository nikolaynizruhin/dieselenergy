<?php

use App\Models\Brand;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;
use Facades\App\Services\Cart;
use Illuminate\Support\Collection;

beforeEach(function () {
    $this->product = Product::factory()->withDefaultImage()->create();
});

it('can add', function () {
    $item = Cart::add($this->product);

    $this->assertEquals($item->id, $this->product->id);
    $this->assertEquals($item->slug, $this->product->slug);
    $this->assertEquals($item->name, $this->product->name);
    $this->assertEquals($item->category, $this->product->category->name);
    $this->assertEquals($item->price, $this->product->price->toUAH()->coins());
    $this->assertEquals($item->image, $this->product->defaultImage()->path);
    $this->assertEquals(1, $item->quantity);
    $this->assertCount(1, Cart::items());
});

it('can add existing product', function () {
    $item = Cart::add($this->product, 2);

    $this->assertEquals(2, $item->quantity);

    $item = Cart::add($this->product, 2);

    $this->assertEquals(4, $item->quantity);
});

it('can remove', function () {
    Cart::add($this->product);

    $this->assertCount(1, Cart::items());

    Cart::delete(0);

    $this->assertCount(0, Cart::items());
});

it('can get items', function () {
    $item = Cart::add($this->product);

    $items = Cart::items();

    $this->assertTrue($items->contains($item));
    $this->assertInstanceOf(Collection::class, $items);
});

it('can_update_cart_item', function () {
    Cart::add($this->product);

    Cart::update(0, 5);

    $this->assertEquals(5, Cart::items()->first()->quantity);
});

it('can get total', function () {
    $currency = Currency::factory()->state(['rate' => 30.0000]);
    $brand = Brand::factory()->for($currency);

    $generator = Product::factory()
        ->for($brand)
        ->withDefaultImage()
        ->create(['price' => 10000]);

    $waterPump = Product::factory()
        ->for($brand)
        ->withDefaultImage()
        ->create(['price' => 10000]);

    Cart::add($generator, 2);
    Cart::add($waterPump);

    $this->assertEquals(900000, Cart::total());
});

it('can be cleared', function () {
    Cart::add($this->product);

    $this->assertCount(1, Cart::items());

    Cart::clear();

    $this->assertCount(0, Cart::items());
});

it('can be stored', function () {
    $order = Order::factory()->create();

    Cart::add($this->product, $quantity = fake()->randomDigitNotNull());

    $this->assertDatabaseCount('order_product', 0);

    Cart::store($order);

    $this->assertDatabaseHas('order_product', [
        'product_id' => $this->product->id,
        'order_id' => $order->id,
        'quantity' => $quantity,
    ]);
});
