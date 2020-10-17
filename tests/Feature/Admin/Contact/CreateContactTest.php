<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use App\Models\User;
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
        $user = User::factory()->create();

        $this->actingAs($user)
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
        $user = User::factory()->create();
        $contact = Contact::factory()->raw();

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.created'));

        $this->assertDatabaseHas('contacts', $contact);
    }

    /** @test */
    public function user_cant_create_contact_without_message()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->raw(['message' => null]);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('message');
    }

    /** @test */
    public function user_cant_create_contact_with_integer_message()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->raw(['message' => 1]);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('message');
    }

    /** @test */
    public function user_cant_create_contact_without_customer()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->raw(['customer_id' => null]);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_create_contact_with_string_customer()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->raw(['customer_id' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_create_contact_with_nonexistent_customer()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->raw(['customer_id' => 1]);

        $this->actingAs($user)
            ->post(route('admin.contacts.store'), $contact)
            ->assertSessionHasErrors('customer_id');
    }
}
