<?php

namespace Tests\Feature\Admin\Contact;

test('guest cant visit create contact page', function () {
    $this->get(route('admin.contacts.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create contact page', function () {
    $this->login()
        ->get(route('admin.contacts.create'))
        ->assertViewIs('admin.contacts.create');
});

test('guest cant create contact', function () {
    $this->post(route('admin.contacts.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create contact', function () {
    $this->login()
        ->post(route('admin.contacts.store'), $fields = validFields())
        ->assertRedirect(route('admin.contacts.index'))
        ->assertSessionHas('status', trans('contact.created'));

    $this->assertDatabaseHas('contacts', $fields);
});

test('user cant create contact with invalid data', function (string $field, callable $data) {
    $this->login()
        ->fromRoute('admin.contacts.create')
        ->post(route('admin.contacts.store'), $data())
        ->assertRedirect(route('admin.contacts.create'))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('contacts', 0);
})->with('create_contact');
