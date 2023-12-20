<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('guest cant visit create image page', function () {
    $this->get(route('admin.images.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create image page', function () {
    $this->login()
        ->get(route('admin.images.create'))
        ->assertViewIs('admin.images.create');
});

test('guest cant create image', function () {
    Storage::fake();

    $image = UploadedFile::fake()->image('product.jpg');

    $this->post(route('admin.images.store'), [
        'images' => [$image],
    ])->assertRedirect(route('admin.login'));
});

test('user can create image', function () {
    Storage::fake();

    $image = UploadedFile::fake()->image('product.jpg');

    $this->login()
        ->post(route('admin.images.store'), [
            'images' => [$image],
        ])->assertRedirect(route('admin.images.index'))
        ->assertSessionHas('status', trans('image.created'));

    Storage::assertExists($path = 'images/'.$image->hashName());

    $this->assertDatabaseHas('images', ['path' => $path]);
});

test('user cant create image with invalid data', function (callable $data) {
    $this->login()
        ->fromRoute('admin.images.create')
        ->post(route('admin.images.store'), ['images' => $data()])
        ->assertRedirect(route('admin.images.create'))
        ->assertSessionHasErrors('images.*');

    $this->assertDatabaseCount('images', 0);
})->with([
    'Image is required' => [
        fn () => [null],
    ],
    'Image cant be an integer' => [
        fn () => [1],
    ],
    'Image cant be a pdf file' => [
        fn () => [UploadedFile::fake()->create('document.pdf', 1, 'application/pdf')],
    ],
]);
