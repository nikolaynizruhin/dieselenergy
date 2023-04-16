<?php

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant read contacts', function () {
    $this->get(route('admin.contacts.index'))
        ->assertRedirect(route('admin.login'));
});

test('user can read contacts', function () {
    [$contactSale, $contactSupport] = Contact::factory()
        ->count(2)
        ->state(new Sequence(
            ['message' => 'Support'],
            ['message' => 'Sale'],
        ))->create();

    $this->login()
        ->get(route('admin.contacts.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.contacts.index')
        ->assertViewHas('contacts')
        ->assertSeeInOrder([$contactSale->message, $contactSupport->message]);
});
