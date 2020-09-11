<?php

namespace Tests\Unit;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
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
        $brand = Brand::factory()->create();
        $product = Product::factory()->create(['brand_id' => $brand->id]);

        $this->assertInstanceOf(Brand::class, $product->brand);
        $this->assertTrue($product->brand->is($brand));
    }

    /** @test */
    public function it_has_category()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertTrue($product->category->is($category));
    }

    /** @test */
    public function it_has_many_attributes()
    {
        $product = Product::factory()->create();
        $attribute = Attribute::factory()->create();

        $product->attributes()
            ->attach($attribute, ['value' => $value = $this->faker->randomDigit]);

        $this->assertTrue($product->attributes->contains($attribute));
        $this->assertInstanceOf(Collection::class, $product->attributes);
        $this->assertEquals($value, $product->attributes->first()->pivot->value);
    }

    /** @test */
    public function it_has_many_orders()
    {
        $product = Product::factory()->create();
        $order = Order::factory()->create();

        $product->orders()->attach($order, ['quantity' => $quantity = $this->faker->randomDigit]);

        $this->assertTrue($product->orders->contains($order));
        $this->assertInstanceOf(Collection::class, $product->orders);
        $this->assertEquals($quantity, $product->orders->first()->pivot->quantity);
    }

    /** @test */
    public function it_has_many_images()
    {
        $product = Product::factory()->create();
        $image = Image::factory()->create();

        $product->images()->attach($image);

        $this->assertTrue($product->images->contains($image));
        $this->assertInstanceOf(Collection::class, $product->images);
    }

    /** @test */
    public function it_has_default_image()
    {
        $product = Product::factory()->create();
        $image = Image::factory()->create();

        $product->images()->attach($image, ['is_default' => 1]);

        $this->assertTrue($product->defaultImage()->is($image));
    }
}
