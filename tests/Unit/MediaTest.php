<?php

use App\Models\Image;
use App\Models\Media;
use App\Models\Product;

it('has product', function () {
    $media = Media::factory()
        ->forProduct()
        ->create();

    $this->assertInstanceOf(Product::class, $media->product);
});

it('has image', function () {
    $media = Media::factory()
        ->forImage()
        ->create();

    $this->assertInstanceOf(Image::class, $media->image);
});

it('can be marked as default', function () {
    $media = Media::factory()
        ->regular()
        ->forImage()
        ->create();

    $media->markAsDefault();

    $this->assertTrue($media->is_default);
});
