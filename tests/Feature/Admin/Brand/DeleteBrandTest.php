<?php

use App\Models\Brand;

beforeEach(function () {
    $this->brand = Brand::factory()->create();
});

test('guest cant delete brand', function () {
    $this->delete(route('admin.brands.destroy', $this->brand))
        ->assertRedirect(route('admin.login'));
});

test('user can delete brand', function () {
    $this->login()
        ->from(route('admin.brands.index'))
        ->delete(route('admin.brands.destroy', $this->brand))
        ->assertRedirect(route('admin.brands.index'))
        ->assertSessionHas('status', trans('brand.deleted'));

    $this->assertModelMissing($this->brand);
});
