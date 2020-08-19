<?php

namespace Tests\Feature\Category;

use App\Attribute;
use App\Category;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_filter_products()
    {
        $generators = factory(Category::class)->create();
        $attribute = factory(Attribute::class)->create();

        $patrol = factory(Product::class)
            ->states('active')
            ->create([
                'name' => 'Patrol Generator',
                'category_id' => $generators->id,
            ]);

        $patrol->attributes()->attach($attribute, ['value' => 10]);

        $diesel = factory(Product::class)
            ->states('active')
            ->create([
                'name' => 'Diesel Generator',
                'category_id' => $generators->id,
            ]);

        $diesel->attributes()->attach($attribute, ['value' => 20]);

        $waterPump = factory(Product::class)
            ->states('active')
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
