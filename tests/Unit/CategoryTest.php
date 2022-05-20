<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /** @test */
    public function it_has_many_products()
    {
        $category = Category::factory()
            ->hasProducts()
            ->create();

        $this->assertInstanceOf(Collection::class, $category->products);
    }

    /** @test */
    public function it_has_many_attributes()
    {
        $category = Category::factory()
            ->hasAttributes()
            ->create();

        $this->assertInstanceOf(Collection::class, $category->attributes);
    }
}
