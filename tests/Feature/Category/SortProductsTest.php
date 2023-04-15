<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function () {
    $this->generators = Category::factory()->create();

    [$this->patrol, $this->diesel] = Product::factory()
        ->count(2)
        ->active()
        ->withDefaultImage()
        ->state(new Sequence(
            ['name' => 'Patrol Generator'],
            ['name' => 'Diesel Generator'],
        ))->create(['category_id' => $this->generators->id]);
});

test('guest can sort products ascending', function () {
    $this->get(route('categories.products.index', [
        'category' => $this->generators,
        'sort' => 'name',
    ]))->assertSuccessful()
        ->assertViewIs('categories.products.index')
        ->assertViewHas('products')
        ->assertSeeInOrder([$this->diesel->name, $this->patrol->name]);
});

test('guest can sort products descending', function () {
    $this->get(route('categories.products.index', [
        'category' => $this->generators,
        'sort' => '-name',
    ]))->assertSuccessful()
        ->assertViewIs('categories.products.index')
        ->assertViewHas('products')
        ->assertSeeInOrder([$this->patrol->name, $this->diesel->name]);
});
