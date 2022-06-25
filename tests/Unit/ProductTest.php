<?php

namespace Tests\Unit;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Support\Money;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function it_has_brand()
    {
        $product = Product::factory()
            ->forBrand()
            ->create();

        $this->assertInstanceOf(Brand::class, $product->brand);
    }

    /** @test */
    public function it_has_category()
    {
        $product = Product::factory()
            ->forCategory()
            ->create();

        $this->assertInstanceOf(Category::class, $product->category);
    }

    /** @test */
    public function it_has_many_attributes()
    {
        $product = Product::factory()
            ->hasAttached(Attribute::factory(), [
                'value' => $value = fake()->randomDigit(),
            ])->create();

        $this->assertInstanceOf(Collection::class, $product->attributes);
        $this->assertEquals($value, $product->attributes->first()->pivot->value);
    }

    /** @test */
    public function it_has_many_orders()
    {
        $product = Product::factory()
            ->hasAttached(Order::factory(), [
                'quantity' => $quantity = fake()->randomDigit(),
            ])->create();

        $this->assertInstanceOf(Collection::class, $product->orders);
        $this->assertEquals($quantity, $product->orders->first()->pivot->quantity);
    }

    /** @test */
    public function it_has_many_images()
    {
        $product = Product::factory()
            ->hasImages()
            ->create();

        $this->assertInstanceOf(Collection::class, $product->images);
    }

    /** @test */
    public function it_has_recommendations()
    {
        $product = Product::factory()->create();

        $products = Product::factory()
            ->active()
            ->forCategory()
            ->count(3)
            ->create();

        $this->assertCount(2, $products->first()->recommendations());
        $this->assertFalse($products->contains($product));
    }

    /** @test */
    public function it_has_default_image()
    {
        $product = Product::factory()->withDefaultImage()->create();

        $this->assertNotNull($product->defaultImage());
        $this->assertInstanceOf(Image::class, $product->defaultImage());
    }

    /** @test */
    public function it_has_price_as_money()
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(Money::class, $product->price);
    }
}
