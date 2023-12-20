<?php

use App\Models\Currency;

beforeEach(function () {
    $this->currency = Currency::factory()->create();
});

test('guest cant delete currency', function () {
    $this->delete(route('admin.currencies.destroy', $this->currency))
        ->assertRedirect(route('admin.login'));
});

test('user can delete category', function () {
    $this->login()
        ->fromRoute('admin.currencies.index')
        ->delete(route('admin.currencies.destroy', $this->currency))
        ->assertRedirect(route('admin.currencies.index'))
        ->assertSessionHas('status', trans('currency.deleted'));

    $this->assertModelMissing($this->currency);
});
