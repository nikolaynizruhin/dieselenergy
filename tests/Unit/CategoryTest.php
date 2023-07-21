<?php

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

it('has many products', function () {
    $category = Category::factory()
        ->hasProducts()
        ->create();

    expect($category->products)->toBeInstanceOf(Collection::class);
});

it('has many attributes', function () {
    $category = Category::factory()
        ->hasAttributes()
        ->create();

    expect($category->attributes)->toBeInstanceOf(Collection::class);
});
