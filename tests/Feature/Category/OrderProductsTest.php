<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Patrol generator.
     *
     * @var \App\Models\Product
     */
    private $patrol;

    /**
     * Diesel generator.
     *
     * @var \App\Models\Product
     */
    private $diesel;

    /**
     * Generators category.
     *
     * @var \App\Models\Category
     */
    private $generators;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generators = Category::factory()->create();

        [$this->patrol, $this->diesel] = Product::factory()
            ->count(2)
            ->active()
            ->hasAttached(Image::factory(), ['is_default' => 1])
            ->state(new Sequence(
                ['name' => 'Patrol Generator'],
                ['name' => 'Diesel Generator'],
            ))->create(['category_id' => $this->generators->id]);
    }

    /** @test */
    public function guest_can_order_products_ascending()
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
    public function guest_can_order_products_descending()
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
