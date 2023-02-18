<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use Tests\TestCase;

class ReadContactTest extends TestCase
{
    /** @test */
    public function guest_cant_read_contact(): void
    {
        $contact = Contact::factory()->create();

        $this->get(route('admin.contacts.show', $contact))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_contact(): void
    {
        $contact = Contact::factory()->create();

        $this->login()
            ->get(route('admin.contacts.show', $contact))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.show')
            ->assertViewHas('contact')
            ->assertSee($contact->customer->name);
    }
}
