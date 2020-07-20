<?php

namespace Tests\Unit;

use App\Attribute;
use App\Category;
use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttributeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_has_many_categories()
    {
        $attribute = factory(Attribute::class)->create();
        $category = factory(Category::class)->create();

        $attribute->categories()->attach($category);

        $this->assertTrue($attribute->categories->contains($category));
        $this->assertInstanceOf(Collection::class, $attribute->categories);
    }

    /** @test */
    public function it_has_many_products()
    {
        $attribute = factory(Attribute::class)->create();
        $product = factory(Product::class)->create();

        $attribute->products()->attach($product, [
            'value' => $value = $this->faker->randomDigit,
        ]);

        $this->assertTrue($attribute->products->contains($product));
        $this->assertInstanceOf(Collection::class, $attribute->products);
        $this->assertEquals($value, $attribute->products->first()->pivot->value);
    }
}
