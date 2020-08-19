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

        $generator = factory(Product::class)
            ->states('active')
            ->create(['category_id' => $generators->id]);

        $waterPump = factory(Product::class)
            ->states('active')
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
        $generators = factory(Category::class)->create();

        $generator = factory(Product::class)
            ->states('active')
            ->create(['category_id' => $generators->id]);

        $waterPump = factory(Product::class)
            ->states('inactive')
            ->create(['category_id' => $generators->id]);

        $this->get(route('categories.products.index', $generators))
            ->assertSuccessful()
            ->assertViewIs('categories.products.index')
            ->assertViewHas('products')
            ->assertSee($generator->name)
            ->assertDontSee($waterPump->name);
    }
}
