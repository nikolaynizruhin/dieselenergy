<?php

namespace Tests\Feature\Category;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_filter_products()
    {
        $generators = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        $patrol = Product::factory()
            ->active()
            ->create([
                'name' => 'Patrol Generator',
                'category_id' => $generators->id,
            ]);

        $patrol->attributes()->attach($attribute, ['value' => 10]);

        $diesel = Product::factory()
            ->active()
            ->create([
                'name' => 'Diesel Generator',
                'category_id' => $generators->id,
            ]);

        $diesel->attributes()->attach($attribute, ['value' => 20]);

        $waterPump = Product::factory()
            ->active()
            ->create([
                'name' => 'Water Pump',
                'category_id' => $generators->id,
            ]);

        $waterPump->attributes()->attach($attribute, ['value' => 30]);

        $this->get(route('categories.products.index', [
            'category' => $generators,
            'filter' => [$attribute->id => [10, 20]],
        ]))->assertSuccessful()
            ->assertViewIs('categories.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$diesel->name, $patrol->name])
            ->assertDontSee($waterPump->name);
    }
}
