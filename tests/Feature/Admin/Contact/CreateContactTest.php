<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
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
        $this->login()
            ->get(route('admin.contacts.create'))
            ->assertViewIs('admin.contacts.create');
    }

    /** @test */
    public function guest_cant_create_contact()
    {
        $contact = Contact::factory()->raw();

        $this->post(route('admin.contacts.store'), $contact)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_contact()
    {
        $contact = Contact::factory()->raw();

        $this->login()
            ->post(route('admin.contacts.store'), $contact)
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.created'));

        $this->assertDatabaseHas('contacts', $contact);
    }

    /** @test */
    public function user_cant_create_contact_with_integer_message()
    {
        $contact = Contact::factory()->raw(['message' => 1]);

        $this->login()
            ->from(route('admin.contacts.create'))
            ->post(route('admin.contacts.store'), $contact)
            ->assertRedirect(route('admin.contacts.create'))
            ->assertSessionHasErrors('message');

        $this->assertDatabaseCount('contacts', 0);
    }

    /** @test */
    public function user_cant_create_contact_without_customer()
    {
        $contact = Contact::factory()->raw(['customer_id' => null]);

        $this->login()
            ->from(route('admin.contacts.create'))
            ->post(route('admin.contacts.store'), $contact)
            ->assertRedirect(route('admin.contacts.create'))
            ->assertSessionHasErrors('customer_id');

        $this->assertDatabaseCount('contacts', 0);
    }

    /** @test */
    public function user_cant_create_contact_with_string_customer()
    {
        $contact = Contact::factory()->raw(['customer_id' => 'string']);

        $this->login()
            ->from(route('admin.contacts.create'))
            ->post(route('admin.contacts.store'), $contact)
            ->assertRedirect(route('admin.contacts.create'))
            ->assertSessionHasErrors('customer_id');

        $this->assertDatabaseCount('contacts', 0);
    }

    /** @test */
    public function user_cant_create_contact_with_nonexistent_customer()
    {
        $contact = Contact::factory()->raw(['customer_id' => 1]);

        $this->login()
            ->from(route('admin.contacts.create'))
            ->post(route('admin.contacts.store'), $contact)
            ->assertRedirect(route('admin.contacts.create'))
            ->assertSessionHasErrors('customer_id');

        $this->assertDatabaseCount('contacts', 0);
    }
}
