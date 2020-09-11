<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_search_products()
    {
        $generators = Category::factory()->create();

        $patrol = Product::factory()
            ->active()
            ->create(['name' => 'Patrol Generator', 'category_id' => $generators->id]);

        $diesel = Product::factory()
            ->active()
            ->create(['name' => 'Diesel Generator', 'category_id' => $generators->id]);

        $waterPump = Product::factory()
            ->active()
            ->create(['name' => 'Water Pump', 'category_id' => $generators->id]);

        $this->get(route('categories.products.index', [
            'category' => $generators,
            'search' => 'generator',
        ]))->assertSuccessful()
            ->assertViewIs('categories.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$diesel->name, $patrol->name])
            ->assertDontSee($waterPump->name);
    }
}
