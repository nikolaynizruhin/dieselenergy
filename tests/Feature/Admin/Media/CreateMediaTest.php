<?php

namespace Tests\Feature\Admin\Media;

use App\Models\Media;
use App\Models\Product;

test('guest cant visit create media page', function () {
    $this->get(route('admin.medias.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create media page', function () {
    $product = Product::factory()->create();

    $this->login()
        ->get(route('admin.medias.create', ['product_id' => $product->id]))
        ->assertViewIs('admin.medias.create');
});

test('guest cant create media', function () {
    $this->post(route('admin.medias.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create media', function () {
    $this->login()
        ->post(route('admin.medias.store'), $fields = validFields())
        ->assertRedirect(route('admin.products.show', $fields['product_id']))
        ->assertSessionHas('status', trans('media.created'));

    $this->assertDatabaseHas('image_product', $fields);
});

test('it should unmark other default medias', function () {
    $media = Media::factory()->default()->create();
    $stub = Media::factory()->default()->raw([
        'product_id' => $media->product_id,
    ]);

    $this->login()
        ->from(route('admin.medias.create'))
        ->post(route('admin.medias.store'), $stub)
        ->assertRedirect(route('admin.products.show', $media->product));

    expect($media->fresh()->is_default)->toBeFalse();
});

test('user cant create media with invalid data', function (string $field, callable $data, int $count = 0) {
    $this->login()
        ->post(route('admin.medias.store'), $data())
        ->assertRedirect()
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('image_product', $count);
})->with([
    'Product is required' => [
        'product_id', fn () => validFields(['product_id' => null]),
    ],
    'Product cant be string' => [
        'product_id', fn () => validFields(['product_id' => 'string']),
    ],
    'Product must exists' => [
        'product_id', fn () => validFields(['product_id' => 10]),
    ],
    'Image is required' => [
        'image_id', fn () => validFields(['image_id' => null]),
    ],
    'Image cant be string' => [
        'image_id', fn () => validFields(['image_id' => 'string']),
    ],
    'Image must exists' => [
        'image_id', fn () => validFields(['image_id' => 10]),
    ],
    'Media must be unique' => [
        'product_id', fn () => Media::factory()->create()->toArray(), 1,
    ],
]);

function validFields(array $overrides = []): array
{
    return Media::factory()->raw($overrides);
}
