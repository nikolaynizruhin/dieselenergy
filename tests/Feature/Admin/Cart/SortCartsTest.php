<?php

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function () {
    $this->order = Order::factory()->create();
});

test('guest cant sort carts', function () {
    $this->get(route('admin.orders.show', [
        'order' => $this->order,
        'sort' => 'quantity',
    ]))->assertRedirect(route('admin.login'));
});

test('admin can sort carts by quantity ascending', function () {
    [$hyundai, $sdmo] = Cart::factory()
        ->count(2)
        ->for($this->order)
        ->state(new Sequence(
            ['quantity' => 1],
            ['quantity' => 2],
        ))->create();

    $this->login()
        ->get(route('admin.orders.show', [
            'order' => $this->order,
            'sort' => 'quantity',
        ]))->assertSuccessful()
        ->assertViewIs('admin.orders.show')
        ->assertViewHas('products')
        ->assertSeeInOrder([$hyundai->product->name, $sdmo->product->name]);
});

test('admin can sort carts by quantity descending', function () {
    [$hyundai, $sdmo] = Cart::factory()
        ->count(2)
        ->for($this->order)
        ->state(new Sequence(
            ['quantity' => 1],
            ['quantity' => 2],
        ))->create();

    $this->login()
        ->get(route('admin.orders.show', [
            'order' => $this->order,
            'sort' => '-quantity',
        ]))->assertSuccessful()
        ->assertViewIs('admin.orders.show')
        ->assertViewHas('products')
        ->assertSeeInOrder([$sdmo->product->name, $hyundai->product->name]);
});

test('admin can sort carts by product name ascending', function () {
    [$diesel, $patrol] = Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Diesel'],
            ['name' => 'Patrol'],
        ))->create();

    [$hyundai, $sdmo] = Cart::factory()
        ->count(2)
        ->for($this->order)
        ->state(new Sequence(
            ['product_id' => $diesel],
            ['product_id' => $patrol],
        ))->create();

    $this->login()
        ->get(route('admin.orders.show', [
            'order' => $this->order,
            'sort' => 'name',
        ]))->assertSuccessful()
        ->assertViewIs('admin.orders.show')
        ->assertViewHas('products')
        ->assertSeeInOrder([$hyundai->product->name, $sdmo->product->name]);
});

test('admin can sort carts by product name descending', function () {
    [$diesel, $patrol] = Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Diesel'],
            ['name' => 'Patrol'],
        ))->create();

    [$hyundai, $sdmo] = Cart::factory()
        ->count(2)
        ->for($this->order)
        ->state(new Sequence(
            ['product_id' => $diesel],
            ['product_id' => $patrol],
        ))->create();

    $this->login()
        ->get(route('admin.orders.show', [
            'order' => $this->order,
            'sort' => '-name',
        ]))->assertSuccessful()
        ->assertViewIs('admin.orders.show')
        ->assertViewHas('products')
        ->assertSeeInOrder([$sdmo->product->name, $hyundai->product->name]);
});

test('admin can sort carts by total price ascending', function () {
    [$diesel, $patrol] = Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['price' => 1000],
            ['price' => 2000],
        ))->create();

    [$hyundai, $sdmo] = Cart::factory()
        ->count(2)
        ->for($this->order)
        ->state(new Sequence(
            ['product_id' => $diesel, 'quantity' => 1],
            ['product_id' => $patrol, 'quantity' => 1],
        ))->create();

    $this->login()
        ->get(route('admin.orders.show', [
            'order' => $this->order,
            'sort' => 'total',
        ]))->assertSuccessful()
        ->assertViewIs('admin.orders.show')
        ->assertViewHas('products')
        ->assertSeeInOrder([$hyundai->product->name, $sdmo->product->name]);
});

test('admin can sort carts by total price descending', function () {
    [$diesel, $patrol] = Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['price' => 1000],
            ['price' => 2000],
        ))->create();

    [$hyundai, $sdmo] = Cart::factory()
        ->count(2)
        ->for($this->order)
        ->state(new Sequence(
            ['product_id' => $diesel, 'quantity' => 1],
            ['product_id' => $patrol, 'quantity' => 1],
        ))->create();

    $this->login()
        ->get(route('admin.orders.show', [
            'order' => $this->order,
            'sort' => '-total',
        ]))->assertSuccessful()
        ->assertViewIs('admin.orders.show')
        ->assertViewHas('products')
        ->assertSeeInOrder([$sdmo->product->name, $hyundai->product->name]);
});
