<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_products()
    {
        $brand = Brand::factory()
            ->hasProducts(1)
            ->create();

        $this->assertInstanceOf(Collection::class, $brand->products);
    }
}
