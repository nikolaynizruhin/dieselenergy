<?php

namespace Tests\Feature\Admin\Product;

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

class UpdateProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_product_page()
    {
        $product = factory(Product::class)->create();

        $this->get(route('admin.products.edit', $product))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_product_page()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $this->actingAs($user)
            ->get(route('admin.products.edit', $product))
            ->assertViewIs('admin.products.edit')
            ->assertViewHas('product', $product)
            ->assertViewHas(['brands']);
    }

    /** @test */
    public function guest_cant_update_product()
    {
        $product = factory(Product::class)->create();

        $this->put(route('admin.products.update', $product), [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ])->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_product()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.updated'));

        $this->assertDatabaseHas('products', $stub);
    }

    /** @test */
    public function user_can_update_product_with_attributes()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();
        $attribute = factory(Attribute::class)->create();

        $category->attributes()->attach($attribute);

        $stub = factory(Product::class)->raw(['category_id' => $category->id]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub + [
                'attributes' => [
                    $attribute->id => $value = $this->faker->randomDigit,
                ],
            ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', 'Product was updated successfully!');

        $this->assertDatabaseHas('products', $stub);
        $this->assertDatabaseHas('attributables', [
            'attributable_id' => $product->id,
            'attributable_type' => Product::class,
            'value' => $value,
        ]);
    }

    /** @test */
    public function user_can_update_product_with_images()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('product.jpg');

        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub + [
                'images' => [$image],
            ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', 'Product was updated successfully!');

        Storage::assertExists($path = 'images/'.$image->hashName());

        $this->assertDatabaseHas('products', $stub);
        $this->assertDatabaseHas('images', ['path' => $path]);
        $this->assertDatabaseHas('image_product', [
            'image_id' => Image::firstWhere('path', $path)->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function user_cant_update_product_without_name()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['name' => null]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_product_with_integer_name()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['name' => 1]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_product_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw([
            'name' => str_repeat('a', 256),
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_product_with_existing_name()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $existing = factory(Product::class)->create();
        $stub = factory(Product::class)->raw([
            'name' => $existing->name,
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_product_without_price()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['price' => null]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_update_product_with_string_price()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['price' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_update_product_with_zero_price()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['price' => 0]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function user_cant_update_product_without_brand()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['brand_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_update_product_with_string_brand()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['brand_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_update_product_with_nonexistent_brand()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['brand_id' => 100]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('brand_id');
    }

    /** @test */
    public function user_cant_update_product_without_category()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['category_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_product_with_string_category()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['category_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_product_with_nonexistent_category()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['category_id' => 100]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_product_with_null_status()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['is_active' => null]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('is_active');
    }

    /** @test */
    public function user_cant_update_product_with_string_status()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw(['is_active' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('is_active');
    }

    /** @test */
    public function user_cant_update_product_with_string_image()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub + [
                'images' => ['string'],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_update_product_with_integer_image()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub + [
                'images' => [1],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_update_product_with_pdf_image()
    {
        $pdf = UploadedFile::fake()->create('document.pdf', 1, 'application/pdf');

        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $stub = factory(Product::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub + [
                'images' => [$pdf],
            ])->assertSessionHasErrors('images.*');
    }

    /** @test */
    public function user_cant_update_product_without_attributes()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $attribute = factory(Attribute::class)->create();

        $category->attributes()->attach($attribute);

        $product = factory(Product::class)->create();

        $stub = factory(Product::class)->raw([
            'category_id' => $category->id,
            'attributes' => [$attribute->id => null],
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertSessionHasErrors('attributes.'.$attribute->id);
    }

    /** @test */
    public function user_cant_create_product_with_attribute_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $attribute = factory(Attribute::class)->create();

        $category->attributes()->attach($attribute);

        $product = factory(Product::class)->create();

        $stub = factory(Product::class)->raw([
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
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $unrelated = factory(Attribute::class)->create();
        $product = factory(Product::class)->create();

        $stub = factory(Product::class)->raw([
            'category_id' => $category->id,
            'attributes' => [$unrelated->id => $this->faker->randomDigit],
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), $stub)
            ->assertRedirect();

        $this->assertFalse($product->fresh()->attributes->contains($unrelated));
    }
}
