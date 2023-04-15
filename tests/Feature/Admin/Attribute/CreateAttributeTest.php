<?php

namespace Tests\Feature\Admin\Attribute;

test('guest cant visit create attribute page', function () {
    $this->get(route('admin.attributes.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create attribute page', function () {
    $this->login()
        ->get(route('admin.attributes.create'))
        ->assertViewIs('admin.attributes.create');
});

test('guest cant create attribute', function () {
    $this->post(route('admin.attributes.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create attribute', function () {
    $this->login()
        ->post(route('admin.attributes.store'), $fields = validFields())
        ->assertRedirect(route('admin.attributes.index'))
        ->assertSessionHas('status', trans('attribute.created'));

    $this->assertDatabaseHas('attributes', $fields);
});

test('user cant create attribute with invalid data', function (string $field, callable $data, int $count = 0) {
    $this->login()
        ->from(route('admin.attributes.create'))
        ->post(route('admin.attributes.store'), $data())
        ->assertRedirect(route('admin.attributes.create'))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('attributes', $count);
})->with('create_attribute');
