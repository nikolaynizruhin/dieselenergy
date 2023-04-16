<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

dataset('create_product', provider());
dataset('update_product', provider(2));
dataset('attribute', attributeProvider());

function provider(int $count = 1): array
{
    return [
        'Name is required' => [
            'name', fn () => validFields(['name' => null]),
        ],
        'Name cant be an integer' => [
            'name', fn () => validFields(['name' => 1]),
        ],
        'Name cant be more than 255 chars' => [
            'name', fn () => validFields(['name' => Str::random(256)]),
        ],
        'Name must be unique' => [
            'name', fn () => validFields(['name' => Product::factory()->create()->name]), $count,
        ],
        'Model is required' => [
            'model', fn () => validFields(['model' => null]),
        ],
        'Model cant be an integer' => [
            'model', fn () => validFields(['model' => 1]),
        ],
        'Model cant be more than 255 chars' => [
            'model', fn () => validFields(['model' => Str::random(256)]),
        ],
        'Model must be unique' => [
            'model', fn () => validFields(['model' => Product::factory()->create()->model]), $count,
        ],
        'Slug must be unique' => [
            'slug', fn () => validFields(['slug' => Product::factory()->create()->slug]), $count,
        ],
        'Slug is required' => [
            'slug', fn () => validFields(['slug' => null]),
        ],
        'Slug cant be an integer' => [
            'slug', fn () => validFields(['slug' => 1]),
        ],
        'Slug cant be more than 255 chars' => [
            'slug', fn () => validFields(['slug' => Str::random(256)]),
        ],
        'Description cant be an integer' => [
            'description', fn () => validFields(['description' => 1]),
        ],
        'Price is required' => [
            'price', fn () => validFields(['price' => null]),
        ],
        'Price cant be a string' => [
            'price', fn () => validFields(['price' => 'string']),
        ],
        'Price cant be zero' => [
            'price', fn () => validFields(['price' => 0]),
        ],
        'Brand is required' => [
            'brand_id', fn () => validFields(['brand_id' => null]),
        ],
        'Brand cant be string' => [
            'brand_id', fn () => validFields(['brand_id' => 'string']),
        ],
        'Brand must exists' => [
            'brand_id', fn () => validFields(['brand_id' => 10]),
        ],
        'Category is required' => [
            'category_id', fn () => validFields(['category_id' => null]),
        ],
        'Category cant be string' => [
            'category_id', fn () => validFields(['category_id' => 'string']),
        ],
        'Category must exists' => [
            'category_id', fn () => validFields(['category_id' => 10]),
        ],
        'Image cant be a string' => [
            'images.*', fn () => validFields() + ['images' => ['string']],
        ],
        'Image cant be an integer' => [
            'images.*', fn () => validFields() + ['images' => [1]],
        ],
        'Image cant be a pdf file' => [
            'images.*', fn () => validFields() + ['images' => [UploadedFile::fake()->create('document.pdf', 1, 'application/pdf')]],
        ],
    ];
}

function attributeProvider(): array
{
    return [
        'Attribute cant be an integer' => [
            fn () => validAttributeFields(1),
        ],
        'Attribute cant be more than 255 chars' => [
            fn () => validAttributeFields(Str::random(256)),
        ],
    ];
}

function validFields(array $overrides = []): array
{
    return Product::factory()->raw($overrides);
}

function validAttributeFields($value): array
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
