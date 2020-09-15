<?php

namespace Tests\Unit;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_has_many_products()
    {
        $category = Category::factory()
            ->hasProducts(1)
            ->create();

        $this->assertInstanceOf(Collection::class, $category->products);
    }

    /** @test */
    public function it_has_many_attributes()
    {
        $category = Category::factory()
            ->hasAttached(Attribute::factory())
            ->create();

        $this->assertInstanceOf(Collection::class, $category->attributes);
    }
}
