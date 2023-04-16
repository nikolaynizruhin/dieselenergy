<?php

use App\Models\Attribute;

beforeEach(function () {
    $this->attribute = Attribute::factory()->create();
});

test('guest cant delete attribute', function () {
    $this->delete(route('admin.attributes.destroy', $this->attribute))
        ->assertRedirect(route('admin.login'));
});

test('user can delete attribute', function () {
    $this->login()
        ->from(route('admin.attributes.index'))
        ->delete(route('admin.attributes.destroy', $this->attribute))
        ->assertRedirect(route('admin.attributes.index'))
        ->assertSessionHas('status', trans('attribute.deleted'));

    $this->assertModelMissing($this->attribute);
});
