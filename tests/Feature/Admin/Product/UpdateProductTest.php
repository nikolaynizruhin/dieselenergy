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

class UpdateProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_product_page()
    {
        $product = Product::factory()->create();

        $this->get(route('admin.products.edit', $product))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_product_page()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.products.edit', $product))
            ->assertViewIs('admin.products.edit')
            ->assertViewHas('product', $product)
            ->assertViewHas(['brands']);
    }

    /** @test */
    public function guest_cant_update_product()
    {
        $product = Product::factory()->create();
        $stub = Product::factory()->raw();

        $this->put(route('admin.products.update', $product), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw();

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.updated'));

        $this->assertDatabaseHas('products', array_merge($stub, [
            'price' => $stub['price'] * 100,
        ]));
    }

    /** @test */
    public function user_can_update_product_with_attributes()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create();
        $attribute = Attribute::factory()->create();

        $category->attributes()->attach($attribute);

        $stub = Product::factory()->raw(['category_id' => $category->id]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub + [
                'attributes' => [
                    $attribute->id => $value = $this->faker->word,
                ],
            ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.updated'));

        $this->assertDatabaseHas('products', array_merge($stub, [
            'price' => $stub['price'] * 100,
        ]));

        $this->assertDatabaseHas('attribute_product', [
            'product_id' => $product->id,
            'value' => $value,
        ]);
    }

    /** @test */
    public function user_can_update_product_with_images()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('product.jpg');

        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw();

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub + [
                'images' => [$image],
            ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.updated'));

        Storage::assertExists($path = 'images/'.$image->hashName());

        $this->assertDatabaseHas('images', ['path' => $path]);

        $this->assertDatabaseHas('image_product', [
            'image_id' => Image::firstWhere('path', $path)->id,
            'product_id' => $product->id,
        ]);

        $this->assertDatabaseHas('products', array_merge($stub, [
            'price' => $stub['price'] * 100,
        ]));
    }

    /** @test */
    public function user_cant_update_product_without_name()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['name' => null]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_product_with_integer_name()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['name' => 1]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_product_with_name_more_than_255_chars()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw([
            'name' => str_repeat('a', 256),
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_product_with_existing_name()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $existing = Product::factory()->create();
        $stub = Product::factory()->raw([
            'name' => $existing->name,
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_product_without_model()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['model' => null]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('model');
    }

    /** @test */
    public function user_cant_update_product_with_integer_model()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['model' => 1]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('model');
    }

    /** @test */
    public function user_cant_update_product_with_model_more_than_255_chars()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw([
            'model' => str_repeat('a', 256),
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('model');
    }

    /** @test */
    public function user_cant_update_product_with_existing_model()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $existing = Product::factory()->create();
        $stub = Product::factory()->raw([
            'model' => $existing->model,
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('model');
    }

    /** @test */
    public function user_cant_update_product_without_slug()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['slug' => null]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_update_product_with_integer_slug()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['slug' => 1]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_update_product_with_slug_more_than_255_chars()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw([
            'slug' => str_repeat('a', 256),
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_update_product_with_existing_slug()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $existing = Product::factory()->create();
        $stub = Product::factory()->raw([
            'slug' => $existing->slug,
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_update_product_without_price()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['price' => null]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_update_product_with_string_price()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['price' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_update_product_with_zero_price()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['price' => 0]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_update_product_without_brand()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['brand_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_update_product_with_string_brand()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['brand_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_update_product_with_nonexistent_brand()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['brand_id' => 100]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_update_product_without_category()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['category_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_product_with_string_category()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['category_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_product_with_nonexistent_category()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw(['category_id' => 100]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_product_with_string_image()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw();

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub + [
                'images' => ['string'],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_update_product_with_integer_image()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw();

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub + [
                'images' => [1],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_update_product_with_pdf_image()
    {
        $pdf = UploadedFile::fake()->create('document.pdf', 1, 'application/pdf');

        $user = User::factory()->create();
        $product = Product::factory()->create();
        $stub = Product::factory()->raw();

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub + [
                'images' => [$pdf],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_update_product_with_integer_attributes()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        $category->attributes()->attach($attribute);

        $product = Product::factory()->create();

        $stub = Product::factory()->raw([
            'category_id' => $category->id,
            'attributes' => [$attribute->id => 1],
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('attributes.'.$attribute->id);
    }

    /** @test */
    public function user_cant_create_product_with_attribute_more_than_255_chars()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        $category->attributes()->attach($attribute);

        $product = Product::factory()->create();

        $stub = Product::factory()->raw([
            'category_id' => $category->id,
            'attributes' => [$attribute->id => str_repeat('a', 256)],
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('attributes.'.$attribute->id);
    }

    /** @test */
    public function unrelated_attribute_should_not_be_attached_to_product()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $unrelated = Attribute::factory()->create();
        $product = Product::factory()->create();

        $stub = Product::factory()->raw([
            'category_id' => $category->id,
            'attributes' => [$unrelated->id => $this->faker->randomDigit],
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertRedirect();

        $this->assertFalse($product->fresh()->attributes->contains($unrelated));
    }
}
