<?php

namespace Tests\Feature\Contact;

use App\Models\Contact;
use App\Notifications\ContactCreated;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

test('guest can create contact', function () {
    $this->from(route('home'))
        ->post(route('contacts.store'), $fields = validFields())
        ->assertRedirect(route('home').'#contact')
        ->assertSessionHas('status', trans('contact.created'));

    $this->assertDatabaseHas('customers', [
        'name' => $fields['name'],
        'email' => $fields['email'],
        'phone' => $fields['phone'],
    ]);

    $this->assertDatabaseHas('contacts', ['message' => $fields['message']]);
});

test('admin should receive an email when contact created', function () {
    Notification::fake();

    $this->from(route('home'))
        ->post(route('contacts.store'), $fields = validFields())
        ->assertRedirect(route('home').'#contact');

    Notification::assertSentTo(
        new AnonymousNotifiable,
        ContactCreated::class,
        fn ($notification, $channels) => $notification->contact->customer->email === $fields['email'],
    );
});

test('guest cant create contact with invalid data', function (string $field, callable $data) {
    $this->from(route('home'))
        ->post(route('contacts.store'), $data())
        ->assertRedirect(route('home').'#contact')
        ->assertInvalid($field);

    $this->assertDatabaseCount('contacts', 0);
})->with([
    'Privacy is required' => [
        'privacy', fn () => validFields(['privacy' => null]),
    ],
    'Name is required' => [
        'name', fn () => validFields(['name' => null]),
    ],
    'Name cant be an integer' => [
        'name', fn () => validFields(['name' => 1]),
    ],
    'Name cant be more than 255 chars' => [
        'name', fn () => validFields(['name' => Str::random(256)]),
    ],
    'Email is required' => [
        'email', fn () => validFields(['email' => null]),
    ],
    'Email cant be an integer' => [
        'email', fn () => validFields(['email' => 1]),
    ],
    'Email cant be more than 255 chars' => [
        'email', fn () => validFields(['email' => Str::random(256)]),
    ],
    'Email must be valid' => [
        'email', fn () => validFields(['email' => 'invalid']),
    ],
    'Phone is required' => [
        'phone', fn () => validFields(['phone' => null]),
    ],
    'Phone must have valid format' => [
        'phone', fn () => validFields(['phone' => 0631234567]),
    ],
    'Message cant be an integer' => [
        'message', fn () => validFields(['message' => 1]),
    ],
]);

test('guest cant create contact with spam', function (callable $data) {
    $this->from(route('home'))
        ->post(route('contacts.store'), $data())
        ->assertSuccessful();

    $this->assertDatabaseCount('contacts', 0);
})->with([
    'Contact cant contain spam' => [
        fn () => validFields([config('honeypot.field') => 'spam']),
    ],
    'Contact cant be created too quickly' => [
        fn () => validFields([config('honeypot.valid_from_field') => time()]),
    ],
]);

function validFields(array $overrides = []): array
{
    $contact = Contact::factory()->make();

    return array_merge([
        'privacy' => 1,
        'name' => $contact->customer->name,
        'email' => $contact->customer->email,
        'phone' => $contact->customer->phone,
        'message' => $contact->message,
    ] + honeypot(), $overrides);
}
