<?php

namespace Tests\Feature\Sitemap;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadSitemapTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_read_sitemap()
    {
        $post = Post::factory()->create();
        $product = Product::factory()->active()->create();

        $this->get(route('sitemap'))
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertViewIs('sitemap')
            ->assertSee(route('posts.show', $post))
            ->assertSee(route('products.show', $product))
            ->assertSee(route('categories.products.index', $product->category));
    }
}
