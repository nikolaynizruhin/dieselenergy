<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_read_category_products()
    {
        [$generators, $waterPumps] = Category::factory()->count(2)->create();

        [$generator, $waterPump] = Product::factory()
            ->count(2)
            ->active()
            ->state(new Sequence(
                ['category_id' => $generators->id],
                ['category_id' => $waterPumps->id],
            ))->create();

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

        [$generator, $waterPump] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['is_active' => true],
                ['is_active' => false],
            ))->create(['category_id' => $generators->id]);

        $this->get(route('categories.products.index', $generators))
            ->assertSuccessful()
            ->assertViewIs('categories.products.index')
            ->assertViewHas('products')
            ->assertSee($generator->name)
            ->assertDontSee($waterPump->name);
    }
}
