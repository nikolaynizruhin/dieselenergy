<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class SortProductsTest extends TestCase
{
    /**
     * Patrol generator.
     */
    private Product $patrol;

    /**
     * Diesel generator.
     */
    private Product $diesel;

    /**
     * Generators category.
     */
    private Category $generators;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generators = Category::factory()->create();

        [$this->patrol, $this->diesel] = Product::factory()
            ->count(2)
            ->active()
            ->withDefaultImage()
            ->state(new Sequence(
                ['name' => 'Patrol Generator'],
                ['name' => 'Diesel Generator'],
            ))->create(['category_id' => $this->generators->id]);
    }

    /** @test */
    public function guest_can_sort_products_ascending(): void
    {
        $this->get(route('categories.products.index', [
            'category' => $this->generators,
            'sort' => 'name',
        ]))->assertSuccessful()
            ->assertViewIs('categories.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$this->diesel->name, $this->patrol->name]);
    }

    /** @test */
    public function guest_can_sort_products_descending(): void
    {
        $this->get(route('categories.products.index', [
            'category' => $this->generators,
            'sort' => '-name',
        ]))->assertSuccessful()
            ->assertViewIs('categories.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$this->patrol->name, $this->diesel->name]);
    }
}
