<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait HasValidation
{
    public function provider($count = 1): array
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
                'name', fn () => $this->validFields(['name' => Product::factory()->create()->name]), $count,
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
                'model', fn () => $this->validFields(['model' => Product::factory()->create()->model]), $count,
            ],
            'Slug must be unique' => [
                'slug', fn () => $this->validFields(['slug' => Product::factory()->create()->slug]), $count,
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
}
