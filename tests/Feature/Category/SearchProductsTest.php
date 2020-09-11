<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_search_products()
    {
        $generators = Category::factory()->create();

        [$patrol, $diesel, $waterPump] = Product::factory()
            ->count(3)
            ->active()
            ->state(new Sequence(
                ['name' => 'Patrol Generator'],
                ['name' => 'Diesel Generator'],
                ['name' => 'Water Pump'],
            ))
            ->create(['category_id' => $generators->id]);

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
