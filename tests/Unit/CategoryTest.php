<?php

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

it('has many products', function () {
    $category = Category::factory()
        ->hasProducts()
        ->create();

    $this->assertInstanceOf(Collection::class, $category->products);
});

it('has many attributes', function () {
    $category = Category::factory()
        ->hasAttributes()
        ->create();

    $this->assertInstanceOf(Collection::class, $category->attributes);
});
