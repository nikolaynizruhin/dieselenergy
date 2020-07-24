<?php

namespace Tests\Feature\Product;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_read_product()
    {
        $product = factory(Product::class)->create();

        $this->get(route('products.show', $product))
            ->assertSuccessful()
            ->assertViewIs('products.show')
            ->assertViewHas('product')
            ->assertSee($product->name);
    }
}
