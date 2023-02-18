<?php

namespace Tests\Feature\Category;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class FilterProductsTest extends TestCase
{
    /** @test */
    public function guest_can_filter_products(): void
    {
        $generators = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        [$patrol, $diesel, $waterPump] = Product::factory()
            ->count(3)
            ->active()
            ->withDefaultImage()
            ->state(new Sequence(
                ['name' => 'Patrol Generator'],
                ['name' => 'Diesel Generator'],
                ['name' => 'Water Pump'],
            ))
            ->create(['category_id' => $generators->id]);

        $patrol->attributes()->attach($attribute, ['value' => 10]);
        $diesel->attributes()->attach($attribute, ['value' => 20]);
        $waterPump->attributes()->attach($attribute, ['value' => 30]);

        $this->get(route('categories.products.index', [
            'category' => $generators,
            'attribute' => [$attribute->id => [10, 20]],
        ]))->assertSuccessful()
            ->assertViewIs('categories.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$diesel->name, $patrol->name])
            ->assertDontSee($waterPump->name);
    }
}
