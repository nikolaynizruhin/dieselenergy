<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_read_category_products()
    {
        [$generators, $waterPumps] = Category::factory()->count(2)->create();

        $generator = Product::factory()
            ->active()
            ->create(['category_id' => $generators->id]);

        $waterPump = Product::factory()
            ->active()
            ->create(['category_id' => $waterPumps->id]);

        $this->get(route('categories.products.index', $generators))
            ->assertSuccessful()
            ->assertViewIs('categories.products.index')
            ->assertViewHas('products')
            ->assertSee($generator->name)
            ->assertDontSee($waterPump->name);
    }

    /** @test */
    public function guest_can_read_only_category_active_products()
    {
        $generators = Category::factory()->create();

        $generator = Product::factory()
            ->active()
            ->create(['category_id' => $generators->id]);

        $waterPump = Product::factory()
            ->inactive()
            ->create(['category_id' => $generators->id]);

        $this->get(route('categories.products.index', $generators))
            ->assertSuccessful()
            ->assertViewIs('categories.products.index')
            ->assertViewHas('products')
            ->assertSee($generator->name)
            ->assertDontSee($waterPump->name);
    }
}
