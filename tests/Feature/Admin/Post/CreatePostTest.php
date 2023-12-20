<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('guest cant visit create post page', function () {
    $this->get(route('admin.posts.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create post page', function () {
    $this->login()
        ->get(route('admin.posts.create'))
        ->assertViewIs('admin.posts.create');
});

test('guest cant create post', function () {
    $this->post(route('admin.posts.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create post', function () {
    Storage::fake();

    $image = UploadedFile::fake()->image('post.jpg');

    $post = validFields();

    unset($post['image_id']);

    $this->login()
        ->post(route('admin.posts.store'), $post + [
            'image' => $image,
        ])->assertRedirect(route('admin.posts.index'))
        ->assertSessionHas('status', trans('post.created'));

    Storage::assertExists($path = 'images/'.$image->hashName());

    $this->assertDatabaseHas('images', ['path' => $path]);
    $this->assertDatabaseHas('posts', $post + [
        'image_id' => Image::firstWhere('path', $path)->id,
    ]);
});

test('user cant create post with invalid data', function (string $field, callable $data, int $count = 0) {
    $this->login()
        ->fromRoute('admin.posts.create')
        ->post(route('admin.posts.store'), $data())
        ->assertRedirect(route('admin.posts.create'))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('posts', $count);
})->with('create_post');
