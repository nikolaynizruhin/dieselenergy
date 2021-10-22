<?php

namespace Tests\Feature\Contact;

use App\Models\Contact;
use App\Notifications\ContactCreated;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\Honeypot;
use Tests\TestCase;

class CreateContactTest extends TestCase
{
    use Honeypot;

    /** @test */
    public function guest_can_create_contact()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $fields = $this->validFields())
            ->assertRedirect(route('home').'#contact')
            ->assertSessionHas('status', trans('contact.created'));

        $this->assertDatabaseHas('customers', [
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
        ]);

        $this->assertDatabaseHas('contacts', ['message' => $fields['message']]);
    }

    /** @test */
    public function admin_should_receive_an_email_when_contact_created()
    {
        Notification::fake();

        $this->from(route('home'))
            ->post(route('contacts.store'), $fields = $this->validFields())
            ->assertRedirect(route('home').'#contact');

        Notification::assertSentTo(
            new AnonymousNotifiable,
            ContactCreated::class,
            fn ($notification, $channels) => $notification->contact->customer->email === $fields['email'],
        );
    }

    /** @test */
    public function guest_cant_create_contact_without_accepting_privacy()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields(['privacy' => null]))
            ->assertRedirect(route('home').'#contact')
            ->assertSessionHasErrors('privacy');
    }

    /** @test */
    public function guest_cant_create_contact_without_name()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields(['name' => null]))
            ->assertRedirect(route('home').'#contact')
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_contact_with_integer_name()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields(['name' => 1]))
            ->assertRedirect(route('home').'#contact')
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_contact_with_name_more_than_255_chars()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields([
                'name' => str_repeat('a', 256),
            ]))->assertRedirect(route('home').'#contact')
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function guest_cant_create_contact_without_email()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields(['email' => null]))
            ->assertRedirect(route('home').'#contact')
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_contact_with_integer_email()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields(['email' => 1]))
            ->assertRedirect(route('home').'#contact')
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_contact_with_email_more_than_255_chars()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields([
                'email' => str_repeat('a', 256),
            ]))->assertRedirect(route('home').'#contact')
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_contact_with_invalid_email()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields(['email' => 'invalid']))
            ->assertRedirect(route('home').'#contact')
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function guest_cant_create_contact_without_phone()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields(['phone' => null]))
            ->assertRedirect(route('home').'#contact')
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_contact_with_incorrect_phone_format()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields(['phone' => 0631234567]))
            ->assertRedirect(route('home').'#contact')
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function guest_cant_create_contact_with_integer_message()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields(['message' => 1]))
            ->assertRedirect(route('home').'#contact')
            ->assertSessionHasErrors('message');
    }

    /** @test */
    public function guest_cant_create_contact_with_spam()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields([
                config('honeypot.field') => 'spam',
            ]))->assertSuccessful();

        $this->assertDatabaseCount('contacts', 0);
    }

    /** @test */
    public function guest_cant_create_contact_too_quickly()
    {
        $this->from(route('home'))
            ->post(route('contacts.store'), $this->validFields([
                config('honeypot.valid_from_field') => time(),
            ]))->assertSuccessful();

        $this->assertDatabaseCount('contacts', 0);
    }

    /**
     * Get valid contact fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        $contact = Contact::factory()->make();

        return array_merge([
            'privacy' => 1,
            'name' => $contact->customer->name,
            'email' => $contact->customer->email,
            'phone' => $contact->customer->phone,
            'message' => $contact->message,
        ] + $this->honeypot(), $overrides);
    }
}
