<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
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
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
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
        $user = User::factory()->create();
        $product = Product::factory()->raw();

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.created'));

        $this->assertDatabaseHas('products', $product);
    }

    /** @test */
    public function user_can_create_product_with_attributes()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        $category->attributes()->attach($attribute);

        $product = Product::factory()->raw(['category_id' => $category->id]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product + [
                'attributes' => [
                    $attribute->id => $value = $this->faker->word,
                ],
            ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.created'));

        $this->assertDatabaseHas('products', $product);
        $this->assertDatabaseHas('attribute_product', ['value' => $value]);
    }

    /** @test */
    public function user_can_create_product_with_images()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('product.jpg');

        $user = User::factory()->create();
        $product = Product::factory()->raw();

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product + [
                'images' => [$image],
            ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.created'));

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
        $user = User::factory()->create();
        $product = Product::factory()->raw(['name' => null]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_product_with_integer_name()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['name' => 1]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_product_with_name_more_than_255_chars()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw([
            'name' => str_repeat('a', 256),
        ]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_product_with_existing_name()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw([
            'name' => $product->name,
        ]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_product_without_model()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['model' => null]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('model');
    }

    /** @test */
    public function user_cant_create_product_with_integer_model()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['model' => 1]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('model');
    }

    /** @test */
    public function user_cant_create_product_with_model_more_than_255_chars()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw([
            'model' => str_repeat('a', 256),
        ]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('model');
    }

    /** @test */
    public function user_cant_create_product_with_existing_model()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['model' => $product->model]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $stub)
            ->assertSessionHasErrors('model');
    }

    /** @test */
    public function user_cant_create_product_without_slug()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['slug' => null]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_create_product_with_integer_slug()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['slug' => 1]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_create_product_with_slug_more_than_255_chars()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw([
            'slug' => str_repeat('a', 256),
        ]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_create_product_with_existing_slug()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['slug' => $product->slug]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $stub)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_create_product_with_integer_description()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['description' => 1]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_cant_create_product_without_price()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['price' => null]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_create_product_with_string_price()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['price' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_create_product_with_zero_price()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['price' => 0]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_create_product_without_brand()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['brand_id' => null]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_create_product_with_string_brand()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['brand_id' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_create_product_with_nonexistent_brand()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['brand_id' => 1]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_create_product_without_category()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['category_id' => null]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_product_with_string_category()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['category_id' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_product_with_nonexistent_category()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['category_id' => 1]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_product_with_string_image()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw();

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product + [
                'images' => ['string'],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_create_product_with_integer_image()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw();

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product + [
                'images' => [1],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_create_product_with_pdf_file()
    {
        $pdf = UploadedFile::fake()->create('document.pdf', 1, 'application/pdf');

        $user = User::factory()->create();
        $product = Product::factory()->raw();

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product + [
                'images' => [$pdf],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function by_default_product_should_be_inactive()
    {
        $user = User::factory()->create();
        $product = Product::factory()->make()->makeHidden('is_active');

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product->toArray())
            ->assertRedirect();

        $this->assertDatabaseHas('products', ['is_active' => 0]);
    }

    /** @test */
    public function user_cant_create_product_with_integer_attributes()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        $category->attributes()->attach($attribute);

        $product = Product::factory()->raw([
            'category_id' => $category->id,
            'attributes' => [$attribute->id => 1],
        ]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('attributes.'.$attribute->id);
    }

    /** @test */
    public function user_cant_create_product_with_attribute_more_than_255_chars()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        $category->attributes()->attach($attribute);

        $product = Product::factory()->raw([
            'category_id' => $category->id,
            'attributes' => [$attribute->id => str_repeat('a', 256)],
        ]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $product)
            ->assertSessionHasErrors('attributes.'.$attribute->id);
    }

    /** @test */
    public function unrelated_attribute_should_not_be_attached_to_product()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $unrelated = Attribute::factory()->create();

        $stub = Product::factory()->raw([
            'category_id' => $category->id,
            'attributes' => [$unrelated->id => $this->faker->randomDigit],
        ]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), $stub)
            ->assertRedirect();

        $product = Product::firstWhere('name', $stub['name']);

        $this->assertFalse($product->attributes->contains($unrelated));
    }
}
