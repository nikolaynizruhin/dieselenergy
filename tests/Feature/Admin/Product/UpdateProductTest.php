<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->product = Product::factory()->create();
});

test('guest cant visit update product page', function () {
    $this->get(route('admin.products.edit', $this->product))
        ->assertRedirect(route('admin.login'));
});

test('user can visit update product page', function () {
    $attribute = Attribute::factory()->create();
    $this->product->category->attributes()->attach($attribute);

    $this->login()
        ->get(route('admin.products.edit', $this->product))
        ->assertViewIs('admin.products.edit')
        ->assertViewHas('product', $this->product)
        ->assertViewHas(['brands']);
});

test('guest cant update product', function () {
    $this->put(route('admin.products.update', $this->product), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can update product', function () {
    $this->login()
        ->put(route('admin.products.update', $this->product), $fields = validFields())
        ->assertRedirect(route('admin.products.index'))
        ->assertSessionHas('status', trans('product.updated'));

    $this->assertDatabaseHas('products', array_merge($fields, [
        'price' => $fields['price'] * 100,
    ]));
});

test('user can update product with attributes', function () {
    $category = Category::factory()->create();
    $attribute = Attribute::factory()->create();

    $category->attributes()->attach($attribute);

    $stub = validFields(['category_id' => $category->id]);

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
});

test('user can update product with images', function () {
    Storage::fake();

    $image = UploadedFile::fake()->image('product.jpg');

    $stub = validFields();

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
});

test('unrelated attribute should not be attached to product', function () {
    $category = Category::factory()->create();
    $unrelated = Attribute::factory()->create();

    $stub = validFields([
        'category_id' => $category->id,
        'attributes' => [$unrelated->id => fake()->randomDigit()],
    ]);

    $this->login()
        ->put(route('admin.products.update', $this->product), $stub)
        ->assertRedirect();

    expect($this->product->fresh()->attributes->contains($unrelated))->toBeFalse();
});

test('user cant update product with invalid data', function (string $field, callable $data, int $count = 1) {
    $this->login()
        ->from(route('admin.products.edit', $this->product))
        ->put(route('admin.products.update', $this->product), $data())
        ->assertRedirect(route('admin.products.edit', $this->product))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('products', $count);
})->with('udpate_product');

test('user cant update product with integer attributes', function (callable $data) {
    [$attributeId, $fields] = $data();

    $this->login()
        ->from(route('admin.products.edit', $this->product))
        ->put(route('admin.products.update', $this->product), $fields)
        ->assertRedirect(route('admin.products.edit', $this->product))
        ->assertSessionHasErrors('attributes.'.$attributeId);

    $this->assertDatabaseCount('products', 1);
})->with('attribute');
