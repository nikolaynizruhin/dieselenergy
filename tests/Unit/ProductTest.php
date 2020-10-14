<?php

namespace Tests\Unit;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Currency;
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
        $product = Product::factory()
            ->for(Brand::factory())
            ->create();

        $this->assertInstanceOf(Brand::class, $product->brand);
    }

    /** @test */
    public function it_has_category()
    {
        $product = Product::factory()
            ->for(Category::factory())
            ->create();

        $this->assertInstanceOf(Category::class, $product->category);
    }

    /** @test */
    public function it_has_many_attributes()
    {
        $product = Product::factory()
            ->hasAttached(Attribute::factory(), [
                'value' => $value = $this->faker->randomDigit,
            ])->create();

        $this->assertInstanceOf(Collection::class, $product->attributes);
        $this->assertEquals($value, $product->attributes->first()->pivot->value);
    }

    /** @test */
    public function it_has_many_orders()
    {
        $product = Product::factory()
            ->hasAttached(Order::factory(), [
                'quantity' => $quantity = $this->faker->randomDigit,
            ])->create();

        $this->assertInstanceOf(Collection::class, $product->orders);
        $this->assertEquals($quantity, $product->orders->first()->pivot->quantity);
    }

    /** @test */
    public function it_has_many_images()
    {
        $product = Product::factory()
            ->hasAttached(Image::factory())
            ->create();

        $this->assertInstanceOf(Collection::class, $product->images);
    }

    /** @test */
    public function it_has_default_image()
    {
        $product = Product::factory()
            ->hasAttached(Image::factory(), ['is_default' => 1])
            ->create();

        $this->assertNotNull($product->defaultImage());
        $this->assertInstanceOf(Image::class, $product->defaultImage());
    }

    /** @test */
    public function it_has_price_in_uah()
    {
        $currency = Currency::factory()->create(['rate' => 33.3057]);
        $brand = Brand::factory()->create(['currency_id' => $currency->id]);

        $product = Product::factory()->create([
            'brand_id' => $brand->id,
            'price' => 10000,
        ]);

        $this->assertEquals(3331, $product->price_in_uah);
    }
}
