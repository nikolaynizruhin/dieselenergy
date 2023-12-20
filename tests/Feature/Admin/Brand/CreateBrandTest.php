<?php

namespace Tests\Feature\Admin\Brand;

test('guest cant visit create brand page', function () {
    $this->get(route('admin.brands.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create brand page', function () {
    $this->login()
        ->get(route('admin.brands.create'))
        ->assertViewIs('admin.brands.create');
});

test('guest cant create brand', function () {
    $this->post(route('admin.brands.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create brand', function () {
    $this->login()
        ->post(route('admin.brands.store'), $fields = validFields())
        ->assertRedirect(route('admin.brands.index'))
        ->assertSessionHas('status', trans('brand.created'));

    $this->assertDatabaseHas('brands', $fields);
});

test('user cant create brand with invalid data', function (string $field, callable $data, int $count = 0) {
    $this->login()
        ->fromRoute('admin.brands.create')
        ->post(route('admin.brands.store'), $data())
        ->assertRedirect(route('admin.brands.create'))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('brands', $count);
})->with('create_brand');
