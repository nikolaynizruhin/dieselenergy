<?php

use App\Models\Contact;

beforeEach(function () {
    $this->contact = Contact::factory()->create();
});

test('guest cant delete contact', function () {
    $this->delete(route('admin.contacts.destroy', $this->contact))
        ->assertRedirect(route('admin.login'));
});

test('user can delete contact', function () {
    $this->login()
        ->fromRoute('admin.contacts.index')
        ->delete(route('admin.contacts.destroy', $this->contact))
        ->assertRedirect(route('admin.contacts.index'))
        ->assertSessionHas('status', trans('contact.deleted'));

    $this->assertModelMissing($this->contact);
});
