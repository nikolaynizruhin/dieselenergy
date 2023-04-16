<?php

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant search contacts', function () {
    $contact = Contact::factory()->create();

    $this->get(route('admin.contacts.index', ['search' => $contact->message]))
        ->assertRedirect(route('admin.login'));
});

test('user can search contacts', function () {
    [$contactSale, $contactSupport, $contactOther] = Contact::factory()
        ->count(3)
        ->state(new Sequence(
            ['message' => 'Sale Contact'],
            ['message' => 'Support Contact'],
            ['message' => 'Other'],
        ))->create();

    $this->login()
        ->get(route('admin.contacts.index', ['search' => 'Contact']))
        ->assertSeeInOrder([$contactSale->message, $contactSupport->message])
        ->assertDontSee($contactOther->message);
});
