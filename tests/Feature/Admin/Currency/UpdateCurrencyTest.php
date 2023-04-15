<?php

namespace Tests\Feature\Admin\Currency;

use App\Models\Currency;

beforeEach(function () {
    $this->currency = Currency::factory()->create();
});

test('guest cant visit edit currency page', function () {
    $this->get(route('admin.currencies.edit', $this->currency))
        ->assertRedirect(route('admin.login'));
});

test('user can visit edit currency page', function () {
    $this->login()
        ->get(route('admin.currencies.edit', $this->currency))
        ->assertViewIs('admin.currencies.edit');
});

test('guest cant update currency', function () {
    $this->put(route('admin.currencies.update', $this->currency), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can update currency', function () {
    $this->login()
        ->put(route('admin.currencies.update', $this->currency), $fields = validFields())
        ->assertRedirect(route('admin.currencies.index'))
        ->assertSessionHas('status', trans('currency.updated'));

    $this->assertDatabaseHas('currencies', $fields);
});

test('user cant update currency with invalid data', function (string $field, callable $data, int $count = 1) {
    $this->login()
        ->from(route('admin.currencies.edit', $this->currency))
        ->put(route('admin.currencies.update', $this->currency), $data())
        ->assertRedirect(route('admin.currencies.edit', $this->currency))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('currencies', $count);
})->with('update_currency');
