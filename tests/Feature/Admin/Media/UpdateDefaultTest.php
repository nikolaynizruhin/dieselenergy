<?php

use App\Models\Media;

beforeEach(function () {
    $this->media = Media::factory()->regular()->create();
});

test('guest cant update default media', function () {
    $this->put(route('admin.medias.default.update', $this->media))
        ->assertRedirect(route('admin.login'));
});

test('user can update default media', function () {
    $this->login()
        ->put(route('admin.medias.default.update', $this->media))
        ->assertRedirect(route('admin.products.show', $this->media->product_id))
        ->assertSessionHas('status', trans('media.updated'));

    $this->assertTrue($this->media->fresh()->is_default);
});

test('it should unmark other default medias', function () {
    $defaultMedia = Media::factory()
        ->default()
        ->create(['product_id' => $this->media->product_id]);

    $this->login()
        ->put(route('admin.medias.default.update', $this->media))
        ->assertRedirect();

    $this->assertFalse($defaultMedia->fresh()->is_default);
    $this->assertTrue($this->media->fresh()->is_default);
});
