<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class BrandTest extends TestCase
{
    /** @test */
    public function it_has_many_products()
    {
        $brand = Brand::factory()
            ->hasProducts(1)
            ->create();

        $this->assertInstanceOf(Collection::class, $brand->products);
    }

    /** @test */
    public function it_has_currency()
    {
        $brand = Brand::factory()->create();

        $this->assertInstanceOf(Currency::class, $brand->currency);
    }
}
