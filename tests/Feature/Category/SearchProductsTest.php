<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\Image;
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

        [$patrol, $diesel] = Product::factory()
            ->count(2)
            ->active()
            ->hasAttached(Image::factory(), ['is_default' => 1])
            ->state(new Sequence(
                ['name' => 'Patrol Generator'],
                ['name' => 'Diesel Generator'],
            ))->create(['category_id' => $generators->id]);

        $this->get(route('categories.products.index', [
            'category' => $generators,
            'search' => 'patrol',
        ]))->assertSuccessful()
            ->assertViewIs('categories.products.index')
            ->assertViewHas('products')
            ->assertSee($patrol->name)
            ->assertDontSee($diesel->name);
    }
}
