<?php

use App\Models\Contact;

test('guest cant read contact', function () {
    $contact = Contact::factory()->create();

    $this->get(route('admin.contacts.show', $contact))
        ->assertRedirect(route('admin.login'));
});

test('user can read contact', function () {
    $contact = Contact::factory()->create();

    $this->login()
        ->get(route('admin.contacts.show', $contact))
        ->assertSuccessful()
        ->assertViewIs('admin.contacts.show')
        ->assertViewHas('contact')
        ->assertSee($contact->customer->name);
});
