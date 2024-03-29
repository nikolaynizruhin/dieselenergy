<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;

beforeEach(function () {
    $this->attribute = Attribute::factory()->create();
});

test('guest_cant_visit_update_attribute_page', function () {
    $this->get(route('admin.attributes.edit', $this->attribute))
        ->assertRedirect(route('admin.login'));
});

test('user_can_visit_update_attribute_page', function () {
    $this->login()
        ->get(route('admin.attributes.edit', $this->attribute))
        ->assertViewIs('admin.attributes.edit')
        ->assertViewHas('attribute', $this->attribute);
});

test('guest_cant_update_attribute', function () {
    $this->put(route('admin.attributes.update', $this->attribute), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user_can_update_attribute', function () {
    $this->login()
        ->put(route('admin.attributes.update', $this->attribute), $fields = validFields())
        ->assertRedirect(route('admin.attributes.index'))
        ->assertSessionHas('status', trans('attribute.updated'));

    $this->assertDatabaseHas('attributes', $fields);
});

test('user_cant_update_attribute_with_invalid_data', function (string $field, callable $data, int $count = 1) {
    $this->login()
        ->fromRoute('admin.attributes.edit', $this->attribute)
        ->put(route('admin.attributes.update', $this->attribute), $data())
        ->assertRedirect(route('admin.attributes.edit', $this->attribute))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('attributes', $count);
})->with('update_attribute');
