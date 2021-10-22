<?php

namespace Tests\Unit;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttributeTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_has_many_categories()
    {
        $attribute = Attribute::factory()
            ->hasCategories()
            ->create();

        $this->assertInstanceOf(Collection::class, $attribute->categories);
    }

    /** @test */
    public function it_has_many_products()
    {
        $attribute = Attribute::factory()
            ->hasAttached(Product::factory(), [
                'value' => $value = $this->faker->randomDigit(),
            ])->create();

        $this->assertInstanceOf(Collection::class, $attribute->products);
        $this->assertEquals($value, $attribute->products->first()->pivot->value);
    }
}
