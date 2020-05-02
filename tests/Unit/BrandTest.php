<?php

namespace Tests\Unit;

use App\Brand;
use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_products()
    {
        $brand = factory(Brand::class)->create();
        $product = factory(Product::class)->create(['brand_id' => $brand->id]);

        $this->assertTrue($brand->products->contains($product));
        $this->assertInstanceOf(Collection::class, $brand->products);
    }
}
