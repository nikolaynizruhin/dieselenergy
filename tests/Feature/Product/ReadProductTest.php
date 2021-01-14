<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_read_product()
    {
        [$generators, $waterPumps] = Category::factory()->count(2)->create();

        [$product, $generator, $waterPump] = Product::factory()
            ->count(3)
            ->active()
            ->hasAttached(Image::factory(), ['is_default' => 1])
            ->state(new Sequence(
                ['category_id' => $generators->id],
                ['category_id' => $generators->id],
                ['category_id' => $waterPumps->id],
            ))->create();

        $this->get(route('products.show', $product))
            ->assertSuccessful()
            ->assertViewIs('products.show')
            ->assertViewHas('product')
            ->assertViewHas('recommendations')
            ->assertSee($product->name)
            ->assertSee($generator->name)
            ->assertDontSee($waterPump->name);
    }
}
