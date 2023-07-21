<?php

use App\Models\Image;
use App\Models\Media;
use App\Models\Product;

it('has product', function () {
    $media = Media::factory()
        ->forProduct()
        ->create();

    expect($media->product)->toBeInstanceOf(Product::class);
});

it('has image', function () {
    $media = Media::factory()
        ->forImage()
        ->create();

    expect($media->image)->toBeInstanceOf(Image::class);
});

it('can be marked as default', function () {
    $media = Media::factory()
        ->regular()
        ->forImage()
        ->create();

    $media->markAsDefault();

    expect($media->is_default)->toBeTrue();
});
