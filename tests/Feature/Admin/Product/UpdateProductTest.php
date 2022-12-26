<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use HasValidation;

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
                    $attribute->id => $value = fake()->word(),
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
            'attributes' => [$unrelated->id => fake()->randomDigit()],
        ]);

        $this->login()
            ->put(route('admin.products.update', $this->product), $stub)
            ->assertRedirect();

        $this->assertFalse($this->product->fresh()->attributes->contains($unrelated));
    }

    /**
     * @test
     *
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

    public function validationProvider()
    {
        return $this->provider(2);
    }

    /**
     * @test
     *
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
}
