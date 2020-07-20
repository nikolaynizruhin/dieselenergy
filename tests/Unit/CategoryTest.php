<?php

namespace Tests\Unit;

use App\Attribute;
use App\Category;
use App\Product;
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
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create(['category_id' => $category->id]);

        $this->assertTrue($category->products->contains($product));
        $this->assertInstanceOf(Collection::class, $category->products);
    }

    /** @test */
    public function it_has_many_attributes()
    {
        $category = factory(Category::class)->create();
        $attribute = factory(Attribute::class)->create();

        $category->attributes()->attach($attribute);

        $this->assertTrue($category->attributes->contains($attribute));
        $this->assertInstanceOf(Collection::class, $category->attributes);
    }
}
