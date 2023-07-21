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

    expect($this->product->id)->toEqual($item->id);
    expect($this->product->slug)->toEqual($item->slug);
    expect($this->product->name)->toEqual($item->name);
    expect($this->product->category->name)->toEqual($item->category);
    expect($this->product->price->toUAH()->coins())->toEqual($item->price);
    expect($this->product->defaultImage()->path)->toEqual($item->image);
    expect($item->quantity)->toEqual(1);
    expect(Cart::items())->toHaveCount(1);
});

it('can add existing product', function () {
    $item = Cart::add($this->product, 2);

    expect($item->quantity)->toEqual(2);

    $item = Cart::add($this->product, 2);

    expect($item->quantity)->toEqual(4);
});

it('can remove', function () {
    Cart::add($this->product);

    expect(Cart::items())->toHaveCount(1);

    Cart::delete(0);

    expect(Cart::items())->toHaveCount(0);
});

it('can get items', function () {
    $item = Cart::add($this->product);

    $items = Cart::items();

    expect($items->contains($item))->toBeTrue();
    expect($items)->toBeInstanceOf(Collection::class);
});

it('can_update_cart_item', function () {
    Cart::add($this->product);

    Cart::update(0, 5);

    expect(Cart::items()->first()->quantity)->toEqual(5);
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

    expect(Cart::total())->toEqual(900000);
});

it('can be cleared', function () {
    Cart::add($this->product);

    expect(Cart::items())->toHaveCount(1);

    Cart::clear();

    expect(Cart::items())->toHaveCount(0);
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
