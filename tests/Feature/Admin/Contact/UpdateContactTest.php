<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;

beforeEach(function () {
    $this->contact = Contact::factory()->create();
});

test('guest cant visit edit contact page', function () {
    $this->get(route('admin.contacts.edit', $this->contact))
        ->assertRedirect(route('admin.login'));
});

test('user can visit update contact page', function () {
    $this->login()
        ->get(route('admin.contacts.edit', $this->contact))
        ->assertViewIs('admin.contacts.edit');
});

test('guest cant update contact', function () {
    $this->put(route('admin.contacts.update', $this->contact), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can update contact', function () {
    $this->login()
        ->put(route('admin.contacts.update', $this->contact), $fields = validFields())
        ->assertRedirect(route('admin.contacts.index'))
        ->assertSessionHas('status', trans('contact.updated'));

    $this->assertDatabaseHas('contacts', $fields);
});

test('user cant update contact with invalid data', function (string $field, callable $data) {
    $this->login()
        ->fromRoute('admin.contacts.edit', $this->contact)
        ->put(route('admin.contacts.update', $this->contact), $data())
        ->assertRedirect(route('admin.contacts.edit', $this->contact))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('contacts', 1);
})->with('update_contact');
