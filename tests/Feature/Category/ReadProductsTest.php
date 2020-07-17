<?php

namespace Tests\Feature\Category;

use App\Category;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_read_category_products()
    {
        [$generators, $waterPumps] = factory(Category::class, 2)->create();

        $generator = factory(Product::class)->create(['category_id' => $generators->id]);
        $waterPump = factory(Product::class)->create(['category_id' => $waterPumps->id]);

        $this->get(route('categories.products.index', $generator))
            ->assertSuccessful()
            ->assertViewIs('categories.products.index')
            ->assertViewHas('products')
            ->assertSee($generator->name)
            ->assertDontSee($waterPump->name);
    }
}
