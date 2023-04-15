<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest can search products', function () {
    $generators = Category::factory()->create();

    [$patrol, $diesel] = Product::factory()
        ->count(2)
        ->active()
        ->withDefaultImage()
        ->state(new Sequence(
            ['name' => 'Patrol Generator'],
            ['name' => 'Diesel Generator'],
        ))->create(['category_id' => $generators->id]);

    $this->get(route('categories.products.index', [
        'category' => $generators,
        'search' => 'patrol',
    ]))->assertSuccessful()
        ->assertViewIs('categories.products.index')
        ->assertViewHas('products')
        ->assertSee($patrol->name)
        ->assertDontSee($diesel->name);
});
