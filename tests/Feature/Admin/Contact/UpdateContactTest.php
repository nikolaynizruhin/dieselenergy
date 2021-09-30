<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateContactTest extends TestCase
{


    /** @test */
    public function guest_cant_visit_edit_contact_page()
    {
        $contact = Contact::factory()->create();

        $this->get(route('admin.contacts.edit', $contact))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_contact_page()
    {
        $contact = Contact::factory()->create();

        $this->login()
            ->get(route('admin.contacts.edit', $contact))
            ->assertViewIs('admin.contacts.edit');
    }

    /** @test */
    public function guest_cant_update_contact()
    {
        $contact = Contact::factory()->create();
        $stub = Contact::factory()->raw();

        $this->put(route('admin.contacts.update', $contact), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_contact()
    {
        $contact = Contact::factory()->create();
        $stub = Contact::factory()->raw();

        $this->login()
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.updated'));

        $this->assertDatabaseHas('contacts', $stub);
    }

    /** @test */
    public function user_cant_update_contact_with_integer_message()
    {
        $contact = Contact::factory()->create();
        $stub = Contact::factory()->raw(['message' => 1]);

        $this->login()
            ->from(route('admin.contacts.edit', $contact))
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertRedirect(route('admin.contacts.edit', $contact))
            ->assertSessionHasErrors('message');

        $this->assertDatabaseCount('contacts', 1);
    }

    /** @test */
    public function user_cant_update_contact_without_customer()
    {
        $contact = Contact::factory()->create();
        $stub = Contact::factory()->raw(['customer_id' => null]);

        $this->login()
            ->from(route('admin.contacts.edit', $contact))
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertRedirect(route('admin.contacts.edit', $contact))
            ->assertSessionHasErrors('customer_id');

        $this->assertDatabaseCount('contacts', 1);
    }

    /** @test */
    public function user_cant_update_contact_with_string_customer()
    {
        $contact = Contact::factory()->create();
        $stub = Contact::factory()->raw(['customer_id' => 'string']);

        $this->login()
            ->from(route('admin.contacts.edit', $contact))
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertRedirect(route('admin.contacts.edit', $contact))
            ->assertSessionHasErrors('customer_id');

        $this->assertDatabaseCount('contacts', 1);
    }

    /** @test */
    public function user_cant_update_contact_with_nonexistent_customer()
    {
        $contact = Contact::factory()->create();
        $stub = Contact::factory()->raw(['customer_id' => 10]);

        $this->login()
            ->from(route('admin.contacts.edit', $contact))
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertRedirect(route('admin.contacts.edit', $contact))
            ->assertSessionHasErrors('customer_id');

        $this->assertDatabaseCount('contacts', 1);
    }
}
