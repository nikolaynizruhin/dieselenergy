<?php

use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('has many products', function () {
    $image = Image::factory()
        ->hasProducts()
        ->create();

    expect($image->products)->toBeInstanceOf(Collection::class);
});

it('has many posts', function () {
    $image = Image::factory()
        ->hasPosts()
        ->create();

    expect($image->posts)->toBeInstanceOf(Collection::class);
});

it('should remove file after image deleted', function () {
    Storage::fake();

    $path = UploadedFile::fake()->image('product.jpg')->store('images');

    $image = Image::create(['path' => $path]);

    Storage::assertExists($path);

    $image->delete();

    Storage::assertMissing($path);
});
