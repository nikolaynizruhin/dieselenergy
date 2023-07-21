<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('guest cant visit create product page', function () {
    $this->get(route('admin.products.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create product page', function () {
    $category = Category::factory()->create();

    $this->login()
        ->get(route('admin.products.create', ['category_id' => $category->id]))
        ->assertViewIs('admin.products.create')
        ->assertViewHas(['brands', 'category']);
});

test('guest cant create product', function () {
    $this->post(route('admin.products.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create product', function () {
    $this->login()
        ->post(route('admin.products.store'), $product = validFields())
        ->assertRedirect(route('admin.products.index'))
        ->assertSessionHas('status', trans('product.created'));

    $this->assertDatabaseHas('products', array_merge($product, [
        'price' => $product['price'] * 100,
    ]));
});

test('user can create product with attributes', function () {
    $category = Category::factory()->create();
    $attribute = Attribute::factory()->create();

    $category->attributes()->attach($attribute);

    $product = validFields(['category_id' => $category->id]);

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
});

test('user can create product with images', function () {
    Storage::fake();

    $image = UploadedFile::fake()->image('product.jpg');

    $product = validFields();

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
});

test('default product should be inactive', function () {
    $this->login()
        ->post(route('admin.products.store'), validFields(['is_active' => null]))
        ->assertRedirect();

    $this->assertDatabaseHas('products', ['is_active' => 0]);
});

test('user cant create product with invalid data', function (string $field, callable $data, int $count = 0) {
    $this->login()
        ->from(route('admin.products.create'))
        ->post(route('admin.products.store'), $data())
        ->assertRedirect(route('admin.products.create'))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('products', $count);
})->with('create_product');

test('user cant create product with invalid attributes', function (callable $data) {
    [$attributeId, $fields] = $data();

    $this->login()
        ->from(route('admin.products.create'))
        ->post(route('admin.products.store'), $fields)
        ->assertRedirect(route('admin.products.create'))
        ->assertSessionHasErrors('attributes.'.$attributeId);

    $this->assertDatabaseCount('products', 0);
})->with('attribute');

test('unrelated attribute should not be attached to product', function () {
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

    expect($product->attributes->contains($unrelated))->toBeFalse();
});
