<?php

namespace Tests\Feature\Category;

use App\Category;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_search_products()
    {
        $generators = factory(Category::class)->create();

        $patrol = factory(Product::class)->create(['name' => 'Patrol Generator', 'category_id' => $generators->id]);
        $diesel = factory(Product::class)->create(['name' => 'Diesel Generator', 'category_id' => $generators->id]);
        $waterPump = factory(Product::class)->create(['name' => 'Water Pump', 'category_id' => $generators->id]);

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
