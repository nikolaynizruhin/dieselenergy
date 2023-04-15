<?php

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Support\Money;
use Illuminate\Database\Eloquent\Collection;

it('has brand', function () {
    $product = Product::factory()
        ->forBrand()
        ->create();

    $this->assertInstanceOf(Brand::class, $product->brand);
});

it('has category', function () {
    $product = Product::factory()
        ->forCategory()
        ->create();

    $this->assertInstanceOf(Category::class, $product->category);
});

it('has many attributes', function () {
    $product = Product::factory()
        ->hasAttached(Attribute::factory(), [
            'value' => $value = fake()->randomDigit(),
        ])->create();

    $this->assertInstanceOf(Collection::class, $product->attributes);
    $this->assertEquals($value, $product->attributes->first()->pivot->value);
});

it('has many orders', function () {
    $product = Product::factory()
        ->hasAttached(Order::factory(), [
            'quantity' => $quantity = fake()->randomDigit(),
        ])->create();

    $this->assertInstanceOf(Collection::class, $product->orders);
    $this->assertEquals($quantity, $product->orders->first()->pivot->quantity);
});

it('has many images', function () {
    $product = Product::factory()
        ->hasImages()
        ->create();

    $this->assertInstanceOf(Collection::class, $product->images);
});

it('has recommendations', function () {
    $product = Product::factory()->create();

    $products = Product::factory()
        ->active()
        ->forCategory()
        ->count(3)
        ->create();

    $this->assertCount(2, $products->first()->recommendations());
    $this->assertFalse($products->contains($product));
});

it('has default image', function () {
    $product = Product::factory()->withDefaultImage()->create();

    $this->assertNotNull($product->defaultImage());
    $this->assertInstanceOf(Image::class, $product->defaultImage());
});

it('has price as money', function () {
    $product = Product::factory()->create();

    $this->assertInstanceOf(Money::class, $product->price);
});
