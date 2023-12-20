<?php

namespace Tests\Feature\Admin\Category;

test('guest cant visit create category page', function () {
    $this->get(route('admin.categories.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create category page', function () {
    $this->login()
        ->get(route('admin.categories.create'))
        ->assertViewIs('admin.categories.create');
});

test('guest cant create category', function () {
    $this->post(route('admin.categories.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create category', function () {
    $this->login()
        ->post(route('admin.categories.store'), $fields = validFields())
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHas('status', trans('category.created'));

    $this->assertDatabaseHas('categories', $fields);
});

test('user cant create category with invalid data', function (string $field, callable $data, int $count = 0) {
    $this->login()
        ->fromRoute('admin.categories.create')
        ->post(route('admin.categories.store'), $data())
        ->assertRedirect(route('admin.categories.create'))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('categories', $count);
})->with('create_category');
