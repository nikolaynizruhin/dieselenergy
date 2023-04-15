<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest can read category products', function () {
    [$generators, $waterPumps] = Category::factory()->count(2)->create();

    [$generator, $waterPump] = Product::factory()
        ->count(2)
        ->active()
        ->withDefaultImage()
        ->state(new Sequence(
            ['category_id' => $generators->id],
            ['category_id' => $waterPumps->id],
        ))->create();

    $this->get(route('categories.products.index', $generators))
        ->assertSuccessful()
        ->assertViewIs('categories.products.index')
        ->assertViewHas('products')
        ->assertSee($generator->name)
        ->assertDontSee($waterPump->name);
});

test('guest can read only category active products', function () {
    $generators = Category::factory()->create();

    [$generator, $waterPump] = Product::factory()
        ->count(2)
        ->withDefaultImage()
        ->state(new Sequence(
            ['is_active' => true],
            ['is_active' => false],
        ))->create(['category_id' => $generators->id]);

    $this->get(route('categories.products.index', $generators))
        ->assertSuccessful()
        ->assertViewIs('categories.products.index')
        ->assertViewHas('products')
        ->assertSee($generator->name)
        ->assertDontSee($waterPump->name);
});
