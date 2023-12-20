<?php

use App\Models\Image;

beforeEach(function () {
    $this->image = Image::factory()->create();
});

test('guest cant delete image', function () {
    $this->delete(route('admin.images.destroy', $this->image))
        ->assertRedirect(route('admin.login'));
});

test('user can delete image', function () {
    $this->login()
        ->fromRoute('admin.images.index')
        ->delete(route('admin.images.destroy', $this->image))
        ->assertRedirect(route('admin.images.index'))
        ->assertSessionHas('status', trans('image.deleted'));

    $this->assertModelMissing($this->image);
});
