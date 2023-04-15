<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;

beforeEach(function () {
    $this->category = Category::factory()->create();
});

test('guest cant visit update category page', function () {
    $this->get(route('admin.categories.edit', $this->category))
        ->assertRedirect(route('admin.login'));
});

test('user can visit update category page', function () {
    $this->login()
        ->get(route('admin.categories.edit', $this->category))
        ->assertViewIs('admin.categories.edit')
        ->assertViewHas('category', $this->category);
});

test('guest cant update category', function () {
    $this->put(route('admin.categories.update', $this->category), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can update category', function () {
    $this->login()
        ->put(route('admin.categories.update', $this->category), $fields = validFields())
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHas('status', trans('category.updated'));

    $this->assertDatabaseHas('categories', $fields);
});

test('user cant update category with invalid data', function (string $field, callable $data, int $count = 1) {
    $this->login()
        ->from(route('admin.categories.edit', $this->category))
        ->put(route('admin.categories.update', $this->category), $data())
        ->assertRedirect(route('admin.categories.edit', $this->category))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('categories', $count);
})->with('update_category');
