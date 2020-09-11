<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_read_product()
    {
        $product = Product::factory()->create();

        $this->get(route('products.show', $product))
            ->assertSuccessful()
            ->assertViewIs('products.show')
            ->assertViewHas('product')
            ->assertSee($product->name);
    }
}
