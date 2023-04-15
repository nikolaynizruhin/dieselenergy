<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('user can read product', function () {
    [$generators, $waterPumps] = Category::factory()->count(2)->create();

    [$product, $generator, $waterPump] = Product::factory()
        ->count(3)
        ->active()
        ->withDefaultImage()
        ->state(new Sequence(
            ['category_id' => $generators->id],
            ['category_id' => $generators->id],
            ['category_id' => $waterPumps->id],
        ))->create();

    $this->get(route('products.show', $product))
        ->assertSuccessful()
        ->assertViewIs('products.show')
        ->assertViewHas('product')
        ->assertSee($product->name)
        ->assertSee($generator->name)
        ->assertDontSee($waterPump->name);
});
