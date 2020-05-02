<?php

namespace Tests\Unit;

use App\Brand;
use App\Category;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

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
}
