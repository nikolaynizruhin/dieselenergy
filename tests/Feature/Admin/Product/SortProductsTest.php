<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant sort products', function () {
    $this->get(route('admin.products.index', ['sort' => 'name']))
        ->assertRedirect(route('admin.login'));
});

test('admin can sort products by name ascending', function () {
    [$patrol, $diesel] = Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Patrol Generator'],
            ['name' => 'Diesel Generator'],
        ))->create();

    $this->login()
        ->get(route('admin.products.index', ['sort' => 'name']))
        ->assertSuccessful()
        ->assertViewIs('admin.products.index')
        ->assertViewHas('products')
        ->assertSeeInOrder([$diesel->name, $patrol->name]);
});

test('admin can sort products by name descending', function () {
    [$patrol, $diesel] = Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Patrol Generator'],
            ['name' => 'Diesel Generator'],
        ))->create();

    $this->login()
        ->get(route('admin.products.index', ['sort' => '-name']))
        ->assertSuccessful()
        ->assertViewIs('admin.products.index')
        ->assertViewHas('products')
        ->assertSeeInOrder([$patrol->name, $diesel->name]);
});

test('admin can sort products by price ascending', function () {
    [$patrol, $diesel] = Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['price' => 200],
            ['price' => 100],
        ))->create();

    $this->login()
        ->get(route('admin.products.index', ['sort' => 'price']))
        ->assertSuccessful()
        ->assertViewIs('admin.products.index')
        ->assertViewHas('products')
        ->assertSeeInOrder([$diesel->name, $patrol->name]);
});

test('admin can sort products by price descending', function () {
    [$patrol, $diesel] = Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['price' => 200],
            ['price' => 100],
        ))->create();

    $this->login()
        ->get(route('admin.products.index', ['sort' => '-price']))
        ->assertSuccessful()
        ->assertViewIs('admin.products.index')
        ->assertViewHas('products')
        ->assertSeeInOrder([$patrol->name, $diesel->name]);
});

test('admin can sort products by status ascending', function () {
    [$patrol, $diesel] = Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['is_active' => true],
            ['is_active' => false],
        ))->create();

    $this->login()
        ->get(route('admin.products.index', ['sort' => 'is_active']))
        ->assertSuccessful()
        ->assertViewIs('admin.products.index')
        ->assertViewHas('products')
        ->assertSeeInOrder([$diesel->name, $patrol->name]);
});

test('admin can sort products by status descending', function () {
    [$patrol, $diesel] = Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['is_active' => true],
            ['is_active' => false],
        ))->create();

    $this->login()
        ->get(route('admin.products.index', ['sort' => '-is_active']))
        ->assertSuccessful()
        ->assertViewIs('admin.products.index')
        ->assertViewHas('products')
        ->assertSeeInOrder([$patrol->name, $diesel->name]);
});

test('admin can sort products by category ascending', function () {
    [$ats, $generators] = Category::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'ATS'],
            ['name' => 'Generators'],
        ))->create();

    Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['category_id' => $ats],
            ['category_id' => $generators],
        ))->create();

    $this->login()
        ->get(route('admin.products.index', ['sort' => 'categories.name']))
        ->assertSuccessful()
        ->assertViewIs('admin.products.index')
        ->assertViewHas('products')
        ->assertSeeInOrder([$ats->name, $generators->name]);
});

test('admin can sort products by category descending', function () {
    [$ats, $generators] = Category::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'ATS'],
            ['name' => 'Generators'],
        ))->create();

    Product::factory()
        ->count(2)
        ->state(new Sequence(
            ['category_id' => $ats],
            ['category_id' => $generators],
        ))->create();

    $this->login()
        ->get(route('admin.products.index', ['sort' => '-categories.name']))
        ->assertSuccessful()
        ->assertViewIs('admin.products.index')
        ->assertViewHas('products')
        ->assertSeeInOrder([$generators->name, $ats->name]);
});
