<?php

namespace Tests\Feature\Contact;

use App\Contact;
use App\Notifications\ContactCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CreateContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_create_contact()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => $contact->customer->email,
                'phone' => $contact->customer->phone,
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertRedirect(route('home'))
                ->assertSessionHas('status', trans('contact.created'));

        $this->assertDatabaseHas('customers', [
            'name' => $contact->customer->name,
            'email' => $contact->customer->email,
            'phone' => $contact->customer->phone,
        ]);

        $this->assertDatabaseHas('contacts', [
            'subject' => $contact->subject,
            'message' => $contact->message,
        ]);
    }

    /** @test */
    public function admin_should_receive_an_email_when_contact_created()
    {
        Notification::fake();

        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => $contact->customer->email,
                'phone' => $contact->customer->phone,
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertRedirect(route('home'));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            ContactCreated::class,
            fn ($notification, $channels) => $notification->contact->customer->email === $contact->customer->email,
        );
    }

    /** @test */
    public function guest_cant_create_contact_without_accept_terms()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'name' => $contact->customer->name,
                'email' => $contact->customer->email,
                'phone' => $contact->customer->phone,
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertRedirect(route('home'))
                ->assertSessionHasErrors('terms');
    }

    /** @test */
    public function guest_cant_create_contact_without_name()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => null,
                'email' => $contact->customer->email,
                'phone' => $contact->customer->phone,
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_contact_with_integer_name()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => 1,
                'email' => $contact->customer->email,
                'phone' => $contact->customer->phone,
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertRedirect(route('home'))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_contact_with_name_more_than_255_chars()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => str_repeat('a', 256),
                'email' => $contact->customer->email,
                'phone' => $contact->customer->phone,
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertRedirect(route('home'))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_contact_without_email()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'phone' => $contact->customer->phone,
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertRedirect(route('home'))
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_contact_with_integer_email()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => 1,
                'phone' => $contact->customer->phone,
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertRedirect(route('home'))
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_contact_with_email_more_than_255_chars()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => str_repeat('a', 256),
                'phone' => $contact->customer->phone,
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertRedirect(route('home'))
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_contact_with_invalid_email()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => 'invalid',
                'phone' => $contact->customer->phone,
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertRedirect(route('home'))
                ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_contact_without_phone()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => $contact->customer->email,
                'phone' => null,
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_contact_with_integer_phone()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => $contact->customer->email,
                'phone' => 1,
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_contact_with_phone_more_than_255_chars()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => $contact->customer->email,
                'phone' => str_repeat('a', 256),
                'subject' => $contact->subject,
                'message' => $contact->message,
            ])->assertRedirect(route('home'))
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_contact_without_subject()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => $contact->customer->email,
                'phone' => $contact->customer->phone,
                'subject' => null,
                'message' => $contact->message,
            ])->assertSessionHasErrors('subject');
    }

    /** @test */
    public function guest_cant_create_contact_with_integer_subject()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => $contact->customer->email,
                'phone' => $contact->customer->phone,
                'subject' => 1,
                'message' => $contact->message,
            ])->assertSessionHasErrors('subject');
    }

    /** @test */
    public function guest_cant_create_contact_with_subject_more_than_255_chars()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => $contact->customer->email,
                'phone' => $contact->customer->phone,
                'subject' => str_repeat('a', 256),
                'message' => $contact->message,
            ])->assertRedirect(route('home'))
            ->assertSessionHasErrors('subject');
    }

    /** @test */
    public function guest_cant_create_contact_without_message()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => $contact->customer->email,
                'phone' => $contact->customer->phone,
                'subject' => $contact->subject,
                'message' => null,
            ])->assertSessionHasErrors('message');
    }

    /** @test */
    public function guest_cant_create_contact_with_integer_message()
    {
        $contact = factory(Contact::class)->make();

        $this->from(route('home'))
            ->post(route('contacts.store'), [
                'terms' => 1,
                'name' => $contact->customer->name,
                'email' => $contact->customer->email,
                'phone' => $contact->customer->phone,
                'subject' => $contact->subject,
                'message' => 1,
            ])->assertSessionHasErrors('message');
    }
}
