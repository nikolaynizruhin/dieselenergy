<?php

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Support\Money;
use Illuminate\Database\Eloquent\Collection;

it('has customer', function () {
    $order = Order::factory()
        ->forCustomer()
        ->create();

    expect($order->customer)->toBeInstanceOf(Customer::class);
});

it('has many products', function () {
    $order = Order::factory()
        ->hasAttached(Product::factory(), [
            'quantity' => $quantity = fake()->randomDigit(),
        ])->create();

    expect($order->products)->toBeInstanceOf(Collection::class);
    expect($order->products->first()->pivot->quantity)->toEqual($quantity);
});

it('calculates total after adding product', function () {
    $currency = Currency::factory()->state(['rate' => 30.0000]);
    $brand = Brand::factory()->for($currency);
    $product = Product::factory()->for($brand)->state(fn () => ['price' => 10000]);

    $order = Order::factory()
        ->hasAttached($product, ['quantity' => 3])
        ->create(['total' => 0]);

    expect($order->fresh()->total->coins())->toEqual(900000);
});

it('calculates total after removing product', function () {
    $cart = Cart::factory()->create();

    expect($cart->order->total->coins())->toBeGreaterThan(0);

    $cart->order->products()->detach($cart->product);

    expect($cart->order->fresh()->total->coins())->toEqual(0);
});

it('has total as money', function () {
    $order = Order::factory()->create();

    expect($order->total)->toBeInstanceOf(Money::class);
});
