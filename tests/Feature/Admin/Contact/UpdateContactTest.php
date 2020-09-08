<?php

namespace Tests\Feature\Admin\Contact;

use App\Contact;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_visit_edit_contact_page()
    {
        $contact = factory(Contact::class)->create();

        $this->get(route('admin.contacts.edit', $contact))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_contact_page()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->create();

        $this->actingAs($user)
            ->get(route('admin.contacts.edit', $contact))
            ->assertViewIs('admin.contacts.edit');
    }

    /** @test */
    public function guest_cant_update_contact()
    {
        $contact = factory(Contact::class)->create();
        $stub = factory(Contact::class)->raw();

        $this->put(route('admin.contacts.update', $contact), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_contact()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->create();
        $stub = factory(Contact::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.updated'));

        $this->assertDatabaseHas('contacts', $stub);
    }

    /** @test */
    public function user_cant_update_contact_without_subject()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->create();
        $stub = factory(Contact::class)->raw(['subject' => null]);

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertSessionHasErrors('subject');
    }

    /** @test */
    public function user_cant_update_contact_with_integer_subject()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->create();
        $stub = factory(Contact::class)->raw(['subject' => 1]);

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertSessionHasErrors('subject');
    }

    /** @test */
    public function user_cant_update_contact_without_message()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->create();
        $stub = factory(Contact::class)->raw(['message' => null]);

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertSessionHasErrors('message');
    }

    /** @test */
    public function user_cant_update_contact_with_integer_message()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->create();
        $stub = factory(Contact::class)->raw(['message' => 1]);

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertSessionHasErrors('message');
    }

    /** @test */
    public function user_cant_update_contact_with_subject_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->create();
        $stub = factory(Contact::class)->raw([
            'subject' => str_repeat('a', 256),
        ]);

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertSessionHasErrors('subject');
    }

    /** @test */
    public function user_cant_update_contact_without_customer()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->create();
        $stub = factory(Contact::class)->raw(['customer_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_contact_with_string_customer()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->create();
        $stub = factory(Contact::class)->raw(['customer_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_contact_with_nonexistent_customer()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->create();
        $stub = factory(Contact::class)->raw(['customer_id' => 10]);

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertSessionHasErrors('customer_id');
    }
}
