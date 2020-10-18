<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateContactTest extends TestCase
{
    use RefreshDatabase;

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
        $user = User::factory()->create();
        $contact = Contact::factory()->create();

        $this->actingAs($user)
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
        $user = User::factory()->create();
        $contact = Contact::factory()->create();
        $stub = Contact::factory()->raw();

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.updated'));

        $this->assertDatabaseHas('contacts', $stub);
    }

    /** @test */
    public function user_cant_update_contact_with_integer_message()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();
        $stub = Contact::factory()->raw(['message' => 1]);

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertSessionHasErrors('message');
    }

    /** @test */
    public function user_cant_update_contact_without_customer()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();
        $stub = Contact::factory()->raw(['customer_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_contact_with_string_customer()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();
        $stub = Contact::factory()->raw(['customer_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_contact_with_nonexistent_customer()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();
        $stub = Contact::factory()->raw(['customer_id' => 10]);

        $this->actingAs($user)
            ->put(route('admin.contacts.update', $contact), $stub)
            ->assertSessionHasErrors('customer_id');
    }
}
