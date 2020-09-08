<?php

namespace Tests\Feature\Admin\Contact;

use App\Contact;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_visit_create_contact_page()
    {
        $this->get(route('admin.contacts.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_contact_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('admin.contacts.create'))
            ->assertViewIs('admin.contacts.create');
    }

    /** @test */
    public function guest_cant_create_contact()
    {
        $contact = factory(Contact::class)->raw();

        $this->post(route('admin.contacts.store'), $contact)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_contact()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->raw();

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.created'));

        $this->assertDatabaseHas('contacts', $contact);
    }

    /** @test */
    public function user_cant_create_contact_without_subject()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->raw(['subject' => null]);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('subject');
    }

    /** @test */
    public function user_cant_create_contact_with_integer_subject()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->raw(['subject' => 1]);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('subject');
    }

    /** @test */
    public function user_cant_create_contact_without_message()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->raw(['message' => null]);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('message');
    }

    /** @test */
    public function user_cant_create_contact_with_integer_message()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->raw(['message' => 1]);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('message');
    }

    /** @test */
    public function user_cant_create_contact_with_subject_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->raw([
            'subject' => str_repeat('a', 256),
        ]);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('subject');
    }

    /** @test */
    public function user_cant_create_contact_without_customer()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->raw(['customer_id' => null]);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_create_contact_with_string_customer()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->raw(['customer_id' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_create_contact_with_nonexistent_customer()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->raw(['customer_id' => 1]);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('customer_id');
    }
}
