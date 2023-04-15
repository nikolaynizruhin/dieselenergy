<?php

use App\Models\Post;
use App\Models\Product;

test('guest_can_read_sitemap', function () {
    $post = Post::factory()->create();
    $product = Product::factory()->active()->create();

    $this->get(route('sitemap'))
        ->assertSuccessful()
        ->assertHeader('Content-Type', 'application/xml')
        ->assertViewIs('sitemap')
        ->assertSee(route('posts.show', $post))
        ->assertSee(route('products.show', $product))
        ->assertSee(route('categories.products.index', $product->category));
});
