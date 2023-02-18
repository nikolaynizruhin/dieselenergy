<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ReadProductTest extends TestCase
{
    /** @test */
    public function user_can_read_product(): void
    {
        [$generators, $waterPumps] = Category::factory()->count(2)->create();

        [$product, $generator, $waterPump] = Product::factory()
            ->count(3)
            ->active()
            ->withDefaultImage()
            ->state(new Sequence(
                ['category_id' => $generators->id],
                ['category_id' => $generators->id],
                ['category_id' => $waterPumps->id],
            ))->create();

        $this->get(route('products.show', $product))
            ->assertSuccessful()
            ->assertViewIs('products.show')
            ->assertViewHas('product')
            ->assertSee($product->name)
            ->assertSee($generator->name)
            ->assertDontSee($waterPump->name);
    }
}
