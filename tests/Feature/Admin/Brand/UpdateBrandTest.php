<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;

beforeEach(function () {
    $this->brand = Brand::factory()->create();
});

test('guest cant visit update brand page', function () {
    $this->get(route('admin.brands.edit', $this->brand))
        ->assertRedirect(route('admin.login'));
});

test('user can visit update brand page', function () {
    $this->login()
        ->get(route('admin.brands.edit', $this->brand))
        ->assertViewIs('admin.brands.edit')
        ->assertViewHas('brand', $this->brand);
});

test('guest cant update brand', function () {
    $this->put(route('admin.brands.update', $this->brand), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can update brand', function () {
    $this->login()
        ->put(route('admin.brands.update', $this->brand), $fields = validFields())
        ->assertRedirect(route('admin.brands.index'))
        ->assertSessionHas('status', trans('brand.updated'));

    $this->assertDatabaseHas('brands', $fields);
});

test('user cant update brand with invalid data', function (string $field, callable $data, $count = 1) {
    $this->login()
        ->fromRoute('admin.brands.edit', $this->brand)
        ->put(route('admin.brands.update', $this->brand), $data())
        ->assertRedirect(route('admin.brands.edit', $this->brand))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('brands', $count);
})->with('update_brand');
