<?php

namespace Tests\Unit;

use App\Attribute;
use App\Brand;
use App\Category;
use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_has_brand()
    {
        $brand = factory(Brand::class)->create();
        $product = factory(Product::class)->create(['brand_id' => $brand->id]);

        $this->assertInstanceOf(Brand::class, $product->brand);
        $this->assertTrue($product->brand->is($brand));
    }

    /** @test */
    public function it_has_category()
    {
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertTrue($product->category->is($category));
    }

    /** @test */
    public function it_has_many_attributes()
    {
        $product = factory(Product::class)->create();
        $attribute = factory(Attribute::class)->create();

        $product->attributes()
            ->attach($attribute->id, ['value' => $value = $this->faker->randomDigit]);

        $this->assertTrue($product->attributes->contains($attribute));
        $this->assertInstanceOf(Collection::class, $product->attributes);
        $this->assertEquals($value, $product->attributes->first()->pivot->value);
    }
}
