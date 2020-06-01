<?php

namespace Tests\Feature\Product;

use App\Attribute;
use App\Category;
use App\Image;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_product_page()
    {
        $this->get(route('products.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_create_product_page()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->get(route('products.create', ['category_id' => $category->id]))
            ->assertViewIs('products.create')
            ->assertViewHas(['brands', 'category']);
    }

    /** @test */
    public function guest_cant_create_product()
    {
        $product = factory(Product::class)->raw();

        $this->post(route('products.store'), $product)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_create_product()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw();

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('status', 'Product was created successfully!');

        $this->assertDatabaseHas('products', $product);
    }

    /** @test */
    public function user_can_create_product_with_attributes()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $attribute = factory(Attribute::class)->create();

        $category->attributes()->attach($attribute);

        $product = factory(Product::class)->raw(['category_id' => $category->id]);

        $this->actingAs($user)
            ->post(route('products.store'), $product + [
                'attributes' => [
                    $attribute->id => $value = $this->faker->randomDigit,
                ],
            ])->assertRedirect(route('products.index'))
            ->assertSessionHas('status', 'Product was created successfully!');

        $this->assertDatabaseHas('products', $product);
        $this->assertDatabaseHas('attributables', [
            'attributable_type' => Product::class,
            'value' => $value,
        ]);
    }

    /** @test */
    public function user_can_create_product_with_images()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('product.jpg');

        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw();

        $this->actingAs($user)
            ->post(route('products.store'), $product + [
                'images' => [$image],
            ])->assertRedirect(route('products.index'))
            ->assertSessionHas('status', 'Product was created successfully!');

        Storage::assertExists($path = 'images/'.$image->hashName());

        $this->assertDatabaseHas('products', $product);
        $this->assertDatabaseHas('images', ['path' => $path]);
        $this->assertDatabaseHas('image_product', [
            'image_id' => Image::firstWhere('path', $path)->id,
            'product_id' => Product::firstWhere('name', $product['name'])->id,
        ]);
    }

    /** @test */
    public function user_cant_create_product_without_name()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['name' => null]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_product_with_integer_name()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['name' => 1]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_product_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw([
            'name' => str_repeat('a', 256),
        ]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_product_with_existing_name()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw([
            'name' => $product->name,
        ]);

        $this->actingAs($user)
            ->post(route('products.store'), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_product_with_integer_description()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['description' => 1]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_cant_create_product_without_price()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['price' => null]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_create_product_with_string_price()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['price' => 'string']);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_create_product_with_zero_price()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['price' => 0]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_create_product_without_brand()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['brand_id' => null]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_create_product_with_string_brand()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['brand_id' => 'string']);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_create_product_with_nonexistent_brand()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['brand_id' => 1]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_create_product_without_category()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['category_id' => null]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_product_with_string_category()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['category_id' => 'string']);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_product_with_nonexistent_category()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['category_id' => 1]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_product_with_null_status()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['is_active' => null]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('is_active');
    }

    /** @test */
    public function user_cant_create_product_with_string_status()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw(['is_active' => 'string']);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('is_active');
    }

    /** @test */
    public function user_cant_create_product_with_string_image()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw();

        $this->actingAs($user)
            ->post(route('products.store'), $product + [
                'images' => ['string'],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_create_product_with_integer_image()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw();

        $this->actingAs($user)
            ->post(route('products.store'), $product + [
                'images' => [1],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_create_product_with_pdf_file()
    {
        $pdf = UploadedFile::fake()->create('document.pdf', 1, 'application/pdf');

        $user = factory(User::class)->create();
        $product = factory(Product::class)->raw();

        $this->actingAs($user)
            ->post(route('products.store'), $product + [
                'images' => [$pdf],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function by_default_product_should_be_inactive()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->make()->makeHidden('is_active');

        $this->actingAs($user)
            ->post(route('products.store'), $product->toArray())
            ->assertRedirect();

        $this->assertDatabaseHas('products', ['is_active' => 0]);
    }

    /** @test */
    public function user_cant_create_product_without_attributes()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $attribute = factory(Attribute::class)->create();

        $category->attributes()->attach($attribute);

        $product = factory(Product::class)->raw([
            'category_id' => $category->id,
            'attributes' => [$attribute->id => null],
        ]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('attributes.'.$attribute->id);
    }

    /** @test */
    public function user_cant_create_product_with_attribute_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $attribute = factory(Attribute::class)->create();

        $category->attributes()->attach($attribute);

        $product = factory(Product::class)->raw([
            'category_id' => $category->id,
            'attributes' => [$attribute->id => str_repeat('a', 256)],
        ]);

        $this->actingAs($user)
            ->post(route('products.store'), $product)
            ->assertSessionHasErrors('attributes.'.$attribute->id);
    }

    /** @test */
    public function unrelated_attribute_should_not_be_attached_to_product()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $unrelated = factory(Attribute::class)->create();

        $stub = factory(Product::class)->raw([
            'category_id' => $category->id,
            'attributes' => [$unrelated->id => $this->faker->randomDigit],
        ]);

        $this->actingAs($user)
            ->post(route('products.store'), $stub)
            ->assertRedirect();

        $product = Product::firstWhere('name', $stub['name']);

        $this->assertFalse($product->attributes->contains($unrelated));
    }
}
