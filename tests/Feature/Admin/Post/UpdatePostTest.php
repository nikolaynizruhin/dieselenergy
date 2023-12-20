<?php

namespace Tests\Feature\Admin\Post;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->post = Post::factory()->create();
});

test('guest cant visit update post page', function () {
    $this->get(route('admin.posts.edit', $this->post))
        ->assertRedirect(route('admin.login'));
});

test('user can visit update post page', function () {
    $this->login()
        ->get(route('admin.posts.edit', $this->post))
        ->assertViewIs('admin.posts.edit')
        ->assertViewHas('post', $this->post);
});

test('guest cant update post', function () {
    $this->put(route('admin.posts.update', $this->post), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can update post', function () {
    Storage::fake();

    $image = UploadedFile::fake()->image('post.jpg');

    $stub = validFields();

    unset($stub['image_id']);

    $this->login()
        ->put(route('admin.posts.update', $this->post), $stub + [
            'image' => $image,
        ])->assertRedirect(route('admin.posts.index'))
        ->assertSessionHas('status', trans('post.updated'));

    Storage::assertExists($path = 'images/'.$image->hashName());

    $this->assertDatabaseHas('images', ['path' => $path]);
    $this->assertDatabaseHas('posts', $stub + [
        'image_id' => Image::firstWhere('path', $path)->id,
    ]);
});

test('user cant update post with invalid data', function (string $field, callable $data, int $count = 1) {
    $this->login()
        ->fromRoute('admin.posts.edit', $this->post)
        ->put(route('admin.posts.update', $this->post), $data())
        ->assertRedirect(route('admin.posts.edit', $this->post))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('posts', $count);
})->with('update_post');
