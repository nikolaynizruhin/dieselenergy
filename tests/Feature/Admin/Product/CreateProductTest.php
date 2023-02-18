<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use HasValidation;

    /** @test */
    public function guest_cant_visit_create_product_page(): void
    {
        $this->get(route('admin.products.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_product_page(): void
    {
        $category = Category::factory()->create();

        $this->login()
            ->get(route('admin.products.create', ['category_id' => $category->id]))
            ->assertViewIs('admin.products.create')
            ->assertViewHas(['brands', 'category']);
    }

    /** @test */
    public function guest_cant_create_product(): void
    {
        $this->post(route('admin.products.store'), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_product(): void
    {
        $this->login()
            ->post(route('admin.products.store'), $product = self::validFields())
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.created'));

        $this->assertDatabaseHas('products', array_merge($product, [
            'price' => $product['price'] * 100,
        ]));
    }

    /** @test */
    public function user_can_create_product_with_attributes(): void
    {
        $category = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        $category->attributes()->attach($attribute);

        $product = self::validFields(['category_id' => $category->id]);

        $this->login()
            ->post(route('admin.products.store'), $product + [
                'attributes' => [
                    $attribute->id => $value = fake()->word(),
                ],
            ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.created'));

        $this->assertDatabaseHas('attribute_product', ['value' => $value]);
        $this->assertDatabaseHas('products', array_merge($product, [
            'price' => $product['price'] * 100,
        ]));
    }

    /** @test */
    public function user_can_create_product_with_images(): void
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('product.jpg');

        $product = self::validFields();

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
    public function by_default_product_should_be_inactive(): void
    {
        $this->login()
            ->post(route('admin.products.store'), self::validFields(['is_active' => null]))
            ->assertRedirect();

        $this->assertDatabaseHas('products', ['is_active' => 0]);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_create_product_with_invalid_data(string $field, callable $data, int $count = 0): void
    {
        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $data())
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('products', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider();
    }

    /**
     * @test
     *
     * @dataProvider validationAttributeProvider
     */
    public function user_cant_create_product_with_invalid_attributes(callable $data): void
    {
        [$attributeId, $fields] = $data();

        $this->login()
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $fields)
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors('attributes.'.$attributeId);

        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function unrelated_attribute_should_not_be_attached_to_product(): void
    {
        $category = Category::factory()->create();
        $unrelated = Attribute::factory()->create();

        $stub = Product::factory()->raw([
            'category_id' => $category->id,
            'attributes' => [$unrelated->id => fake()->randomDigit()],
        ]);

        $this->login()
            ->post(route('admin.products.store'), $stub)
            ->assertRedirect();

        $product = Product::firstWhere('name', $stub['name']);

        $this->assertFalse($product->attributes->contains($unrelated));
    }
}
