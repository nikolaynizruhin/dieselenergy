<?php

use App\Models\Media;

beforeEach(function () {
    $this->media = Media::factory()->create();
});

test('guest cant delete media', function () {
    $this->delete(route('admin.medias.destroy', $this->media))
        ->assertRedirect(route('admin.login'));
});

test('user can delete media', function () {
    $this->login()
        ->from(route('admin.products.show', $this->media->product))
        ->delete(route('admin.medias.destroy', $this->media))
        ->assertRedirect(route('admin.products.show', $this->media->product))
        ->assertSessionHas('status', trans('media.deleted'));

    $this->assertModelMissing($this->media);
});
