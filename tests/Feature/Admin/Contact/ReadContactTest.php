<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_contact()
    {
        $contact = Contact::factory()->create();

        $this->get(route('admin.contacts.show', $contact))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_contact()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.contacts.show', $contact))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.show')
            ->assertViewHas('contact')
            ->assertSee($contact->subject)
            ->assertSee($contact->customer->name);
    }
}
