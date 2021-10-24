<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use WithFaker;

    /**
     * Product.
     *
     * @var \App\Models\Product
     */
    private $product;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_product_page()
    {
        $this->get(route('admin.products.edit', $this->product))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_product_page()
    {
        $attribute = Attribute::factory()->create();
        $this->product->category->attributes()->attach($attribute);

        $this->login()
            ->get(route('admin.products.edit', $this->product))
            ->assertViewIs('admin.products.edit')
            ->assertViewHas('product', $this->product)
            ->assertViewHas(['brands']);
    }

    /** @test */
    public function guest_cant_update_product()
    {
        $this->put(route('admin.products.update', $this->product), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_product()
    {
        $this->login()
            ->put(route('admin.products.update', $this->product), $fields = $this->validFields())
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.updated'));

        $this->assertDatabaseHas('products', array_merge($fields, [
            'price' => $fields['price'] * 100,
        ]));
    }

    /** @test */
    public function user_can_update_product_with_attributes()
    {
        $category = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        $category->attributes()->attach($attribute);

        $stub = $this->validFields(['category_id' => $category->id]);

        $this->login()
            ->put(route('admin.products.update', $this->product), $stub + [
                'attributes' => [
                    $attribute->id => $value = $this->faker->word(),
                ],
            ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.updated'));

        $this->assertDatabaseHas('products', array_merge($stub, [
            'price' => $stub['price'] * 100,
        ]));

        $this->assertDatabaseHas('attribute_product', [
            'product_id' => $this->product->id,
            'value' => $value,
        ]);
    }

    /** @test */
    public function user_can_update_product_with_images()
    {
        Storage::fake();

        $image = UploadedFile::fake()->image('product.jpg');

        $stub = $this->validFields();

        $this->login()
            ->put(route('admin.products.update', $this->product), $stub + [
                'images' => [$image],
            ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.updated'));

        Storage::assertExists($path = 'images/'.$image->hashName());

        $this->assertDatabaseHas('images', ['path' => $path]);

        $this->assertDatabaseHas('image_product', [
            'image_id' => Image::firstWhere('path', $path)->id,
            'product_id' => $this->product->id,
        ]);

        $this->assertDatabaseHas('products', array_merge($stub, [
            'price' => $stub['price'] * 100,
        ]));
    }

    /** @test */
    public function unrelated_attribute_should_not_be_attached_to_product()
    {
        $category = Category::factory()->create();
        $unrelated = Attribute::factory()->create();

        $stub = $this->validFields([
            'category_id' => $category->id,
            'attributes' => [$unrelated->id => $this->faker->randomDigit()],
        ]);

        $this->login()
            ->put(route('admin.products.update', $this->product), $stub)
            ->assertRedirect();

        $this->assertFalse($this->product->fresh()->attributes->contains($unrelated));
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_product_with_invalid_data($field, $data, $count = 1)
    {
        $this->login()
            ->from(route('admin.products.edit', $this->product))
            ->put(route('admin.products.update', $this->product), $data())
            ->assertRedirect(route('admin.products.edit', $this->product))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('products', $count);
    }

    public function validationProvider(): array
    {
        return [
            'Name is required' => [
                'name', fn () => $this->validFields(['name' => null]),
            ],
            'Name cant be an integer' => [
                'name', fn () => $this->validFields(['name' => 1]),
            ],
            'Name cant be more than 255 chars' => [
                'name', fn () => $this->validFields(['name' => Str::random(256)]),
            ],
            'Name must be unique' => [
                'name', fn () => $this->validFields(['name' => Product::factory()->create()->name]), 2,
            ],
            'Model is required' => [
                'model', fn () => $this->validFields(['model' => null]),
            ],
            'Model cant be an integer' => [
                'model', fn () => $this->validFields(['model' => 1]),
            ],
            'Model cant be more than 255 chars' => [
                'model', fn () => $this->validFields(['model' => Str::random(256)]),
            ],
            'Model must be unique' => [
                'model', fn () => $this->validFields(['model' => Product::factory()->create()->model]), 2,
            ],
            'Slug must be unique' => [
                'slug', fn () => $this->validFields(['slug' => Product::factory()->create()->slug]), 2,
            ],
            'Slug is required' => [
                'slug', fn () => $this->validFields(['slug' => null]),
            ],
            'Slug cant be an integer' => [
                'slug', fn () => $this->validFields(['slug' => 1]),
            ],
            'Slug cant be more than 255 chars' => [
                'slug', fn () => $this->validFields(['slug' => Str::random(256)]),
            ],
            'Description cant be an integer' => [
                'description', fn () => $this->validFields(['description' => 1]),
            ],
            'Price is required' => [
                'price', fn () => $this->validFields(['price' => null]),
            ],
            'Price cant be a string' => [
                'price', fn () => $this->validFields(['price' => 'string']),
            ],
            'Price cant be zero' => [
                'price', fn () => $this->validFields(['price' => 0]),
            ],
            'Brand is required' => [
                'brand_id', fn () => $this->validFields(['brand_id' => null]),
            ],
            'Brand cant be string' => [
                'brand_id', fn () => $this->validFields(['brand_id' => 'string']),
            ],
            'Brand must exists' => [
                'brand_id', fn () => $this->validFields(['brand_id' => 10]),
            ],
            'Category is required' => [
                'category_id', fn () => $this->validFields(['category_id' => null]),
            ],
            'Category cant be string' => [
                'category_id', fn () => $this->validFields(['category_id' => 'string']),
            ],
            'Category must exists' => [
                'category_id', fn () => $this->validFields(['category_id' => 10]),
            ],
            'Image cant be a string' => [
                'images.*', fn () => $this->validFields() + ['images' => ['string']],
            ],
            'Image cant be an integer' => [
                'images.*', fn () => $this->validFields() + ['images' => [1]],
            ],
            'Image cant be a pdf file' => [
                'images.*', fn () => $this->validFields() + ['images' => [UploadedFile::fake()->create('document.pdf', 1, 'application/pdf')]],
            ],
        ];
    }

    /**
     * Get valid product fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Product::factory()->raw($overrides);
    }

    /**
     * @test
     * @dataProvider validationAttributeProvider
     */
    public function user_cant_update_product_with_integer_attributes($data)
    {
        [$attributeId, $fields] = $data();

        $this->login()
            ->from(route('admin.products.edit', $this->product))
            ->put(route('admin.products.update', $this->product), $fields)
            ->assertRedirect(route('admin.products.edit', $this->product))
            ->assertSessionHasErrors('attributes.'.$attributeId);

        $this->assertDatabaseCount('products', 1);
    }

    public function validationAttributeProvider(): array
    {
        return [
            'Attribute cant be an integer' => [
                fn () => $this->validAttributeFields(1),
            ],
            'Attribute cant be more than 255 chars' => [
                fn () => $this->validAttributeFields(Str::random(256)),
            ],
        ];
    }

    /**
     * Get valid product attribute fields.
     *
     * @param  mixed  $value
     * @return array
     */
    private function validAttributeFields($value)
    {
        $category = Category::factory()->create();
        $attribute = Attribute::factory()->create();

        $category->attributes()->attach($attribute);

        return [
            $attribute->id,
            Product::factory()->raw([
                'category_id' => $category->id,
                'attributes' => [$attribute->id => $value],
            ]),
        ];
    }
}
