<?php

use App\Models\Category;

beforeEach(function () {
    $this->category = Category::factory()->create();
});

test('guest cant delete category', function () {
    $this->delete(route('admin.categories.destroy', $this->category))
        ->assertRedirect(route('admin.login'));
});

test('user can delete category', function () {
    $this->login()
        ->from(route('admin.categories.index'))
        ->delete(route('admin.categories.destroy', $this->category))
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHas('status', trans('category.deleted'));

    $this->assertModelMissing($this->category);
});
