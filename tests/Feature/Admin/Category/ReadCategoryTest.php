<?php

use App\Models\Category;

test('guest cant read category', function () {
    $category = Category::factory()->create();

    $this->get(route('admin.categories.show', $category))
        ->assertRedirect(route('admin.login'));
});

test('user can read category', function () {
    $category = Category::factory()->create();

    $this->login()
        ->get(route('admin.categories.show', $category))
        ->assertSuccessful()
        ->assertViewIs('admin.categories.show')
        ->assertViewHas('category')
        ->assertSee($category->name);
});
