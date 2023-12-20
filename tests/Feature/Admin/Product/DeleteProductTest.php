<?php

use App\Models\Product;

beforeEach(function () {
    $this->product = Product::factory()->create();
});

test('guest cant delete product', function () {
    $this->delete(route('admin.products.destroy', $this->product))
        ->assertRedirect(route('admin.login'));
});

test('user can delete product', function () {
    $this->login()
        ->fromRoute('admin.products.index')
        ->delete(route('admin.products.destroy', $this->product))
        ->assertRedirect(route('admin.products.index'))
        ->assertSessionHas('status', trans('product.deleted'));

    $this->assertModelMissing($this->product);
});
