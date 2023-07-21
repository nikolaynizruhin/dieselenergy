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

    expect($product->brand)->toBeInstanceOf(Brand::class);
});

it('has category', function () {
    $product = Product::factory()
        ->forCategory()
        ->create();

    expect($product->category)->toBeInstanceOf(Category::class);
});

it('has many attributes', function () {
    $product = Product::factory()
        ->hasAttached(Attribute::factory(), [
            'value' => $value = fake()->randomDigit(),
        ])->create();

    expect($product->attributes)->toBeInstanceOf(Collection::class);
    expect($product->attributes->first()->pivot->value)->toEqual($value);
});

it('has many orders', function () {
    $product = Product::factory()
        ->hasAttached(Order::factory(), [
            'quantity' => $quantity = fake()->randomDigit(),
        ])->create();

    expect($product->orders)->toBeInstanceOf(Collection::class);
    expect($product->orders->first()->pivot->quantity)->toEqual($quantity);
});

it('has many images', function () {
    $product = Product::factory()
        ->hasImages()
        ->create();

    expect($product->images)->toBeInstanceOf(Collection::class);
});

it('has recommendations', function () {
    $product = Product::factory()->create();

    $products = Product::factory()
        ->active()
        ->forCategory()
        ->count(3)
        ->create();

    expect($products->first()->recommendations())->toHaveCount(2);
    expect($products->contains($product))->toBeFalse();
});

it('has default image', function () {
    $product = Product::factory()->withDefaultImage()->create();

    expect($product->defaultImage())->not->toBeNull();
    expect($product->defaultImage())->toBeInstanceOf(Image::class);
});

it('has price as money', function () {
    $product = Product::factory()->create();

    expect($product->price)->toBeInstanceOf(Money::class);
});
