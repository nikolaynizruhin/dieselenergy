<?php

namespace Tests\Feature\Admin\Currency;

test('guest cant visit create currency page', function () {
    $this->get(route('admin.currencies.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create currency page', function () {
    $this->login()
        ->get(route('admin.currencies.create'))
        ->assertViewIs('admin.currencies.create');
});

test('guest cant create currency', function () {
    $this->post(route('admin.currencies.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create currency', function () {
    $this->login()
        ->post(route('admin.currencies.store'), $fields = validFields())
        ->assertRedirect(route('admin.currencies.index'))
        ->assertSessionHas('status', trans('currency.created'));

    $this->assertDatabaseHas('currencies', $fields);
});

test('user cant create currency with invalid data', function (string $field, callable $data, int $count = 0) {
    $this->login()
        ->fromRoute('admin.currencies.create')
        ->post(route('admin.currencies.store'), $data())
        ->assertRedirect(route('admin.currencies.create'))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('currencies', $count);
})->with('create_currency');
