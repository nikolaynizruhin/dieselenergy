<?php

namespace Tests\Unit;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class AttributeTest extends TestCase
{
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
                'value' => $value = fake()->randomDigit(),
            ])->create();

        $this->assertInstanceOf(Collection::class, $attribute->products);
        $this->assertEquals($value, $attribute->products->first()->pivot->value);
    }
}
