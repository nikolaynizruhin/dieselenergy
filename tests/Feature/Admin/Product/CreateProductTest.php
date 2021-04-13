<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
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
        $this->get(route('admin.products.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_product_page()
    {
        $category = Category::factory()->create();

        $this->login()
            ->get(route('admin.products.create', ['category_id' => $category->id]))
            ->assertViewIs('admin.products.create')
            ->assertViewHas(['brands', 'category']);
    }

    /** @test */
    public function guest_cant_create_product()
    {
        $product = Product::factory()->raw();

        $this->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_product()
    {
        $product = Product::factory()->raw();

        $this->login()
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.created'));

        $this->assertDatabaseHas('products', array_merge($product, [
            'price' => $product['price'] * 100,
        ]));
    }

    /** @test */
    public function user_can_create_product_with_attributes()
    {
        $category = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        $category->attributes()->attach($attribute);

        $product = Product::factory()->raw(['category_id' => $category->id]);

        $this->login()
            ->post(route('admin.products.store'), $product + [
                'attributes' => [
                    $attribute->id => $value = $this->faker->word(),
                ],
            ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.created'));

        $this->assertDatabaseHas('attribute_product', ['value' => $value]);
        $this->assertDatabaseHas('products', array_merge($product, [
            'price' => $product['price'] * 100,
        ]));
    }

    /** @test */
    public function user_can_create_product_with_images()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('product.jpg');

        $product = Product::factory()->raw();

        $this->login()
            ->post(route('admin.products.store'), $product + [
                'images' => [$image],
            ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.created'));

        Storage::assertExists($path = 'images/'.$image->hashName());

        $this->assertDatabaseHas('images', ['path' => $path]);

        $this->assertDatabaseHas('image_product', [
            'image_id' => Image::firstWhere('path', $path)->id,
            'product_id' => Product::firstWhere('name', $product['name'])->id,
        ]);

        $this->assertDatabaseHas('products', array_merge($product, [
            'price' => $product['price'] * 100,
        ]));
    }

    /** @test */
    public function user_cant_create_product_without_name()
    {
        $product = Product::factory()->raw(['name' => null]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_integer_name()
    {
        $product = Product::factory()->raw(['name' => 1]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_name_more_than_255_chars()
    {
        $product = Product::factory()->raw([
            'name' => str_repeat('a', 256),
        ]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_existing_name()
    {
        $product = Product::factory()->create();
        $stub = Product::factory()->raw([
            'name' => $product->name,
        ]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $stub)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('products', 1);
    }

    /** @test */
    public function user_cant_create_product_without_model()
    {
        $product = Product::factory()->raw(['model' => null]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('model');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_integer_model()
    {
        $product = Product::factory()->raw(['model' => 1]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('model');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_model_more_than_255_chars()
    {
        $product = Product::factory()->raw([
            'model' => str_repeat('a', 256),
        ]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('model');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_existing_model()
    {
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['model' => $product->model]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $stub)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('model');

        $this->assertDatabaseCount('products', 1);
    }

    /** @test */
    public function user_cant_create_product_without_slug()
    {
        $product = Product::factory()->raw(['slug' => null]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_integer_slug()
    {
        $product = Product::factory()->raw(['slug' => 1]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_slug_more_than_255_chars()
    {
        $product = Product::factory()->raw([
            'slug' => str_repeat('a', 256),
        ]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_existing_slug()
    {
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['slug' => $product->slug]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $stub)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('products', 1);
    }

    /** @test */
    public function user_cant_create_product_with_integer_description()
    {
        $product = Product::factory()->raw(['description' => 1]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('description');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_without_price()
    {
        $product = Product::factory()->raw(['price' => null]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('price');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_string_price()
    {
        $product = Product::factory()->raw(['price' => 'string']);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('price');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_zero_price()
    {
        $product = Product::factory()->raw(['price' => 0]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('price');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_without_brand()
    {
        $product = Product::factory()->raw(['brand_id' => null]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('brand_id');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_string_brand()
    {
        $product = Product::factory()->raw(['brand_id' => 'string']);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('brand_id');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_nonexistent_brand()
    {
        $product = Product::factory()->raw(['brand_id' => 1]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('brand_id');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_without_category()
    {
        $product = Product::factory()->raw(['category_id' => null]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_string_category()
    {
        $product = Product::factory()->raw(['category_id' => 'string']);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_nonexistent_category()
    {
        $product = Product::factory()->raw(['category_id' => 1]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_string_image()
    {
        $product = Product::factory()->raw();

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product + [
                'images' => ['string'],
            ])->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('images.*');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_integer_image()
    {
        $product = Product::factory()->raw();

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product + [
                'images' => [1],
            ])->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('images.*');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_pdf_file()
    {
        $pdf = UploadedFile::fake()->create('document.pdf', 1, 'application/pdf');

        $product = Product::factory()->raw();

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product + [
                'images' => [$pdf],
            ])->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('images.*');

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function by_default_product_should_be_inactive()
    {
        $product = Product::factory()->make()->makeHidden('is_active');

        $this->login()
            ->post(route('admin.products.store'), $product->toArray())
            ->assertRedirect();

        $this->assertDatabaseHas('products', ['is_active' => 0]);
    }

    /** @test */
    public function user_cant_create_product_with_integer_attributes()
    {
        $category = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        $category->attributes()->attach($attribute);

        $product = Product::factory()->raw([
            'category_id' => $category->id,
            'attributes' => [$attribute->id => 1],
        ]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('attributes.'.$attribute->id);

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function user_cant_create_product_with_attribute_more_than_255_chars()
    {
        $category = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        $category->attributes()->attach($attribute);

        $product = Product::factory()->raw([
            'category_id' => $category->id,
            'attributes' => [$attribute->id => str_repeat('a', 256)],
        ]);

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('attributes.'.$attribute->id);

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function unrelated_attribute_should_not_be_attached_to_product()
    {
        $category = Category::factory()->create();
        $unrelated = Attribute::factory()->create();

        $stub = Product::factory()->raw([
            'category_id' => $category->id,
            'attributes' => [$unrelated->id => $this->faker->randomDigit()],
        ]);

        $this->login()
            ->post(route('admin.products.store'), $stub)
            ->assertRedirect();

        $product = Product::firstWhere('name', $stub['name']);

        $this->assertFalse($product->attributes->contains($unrelated));
    }
}
