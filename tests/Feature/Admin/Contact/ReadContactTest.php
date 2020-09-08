<?php

namespace Tests\Feature\Admin\Contact;

use App\Contact;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_contact()
    {
        $contact = factory(Contact::class)->create();

        $this->get(route('admin.contacts.show', $contact))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_contact()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->create();

        $this->actingAs($user)
            ->get(route('admin.contacts.show', $contact))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.show')
            ->assertViewHas('contact')
            ->assertSee($contact->subject)
            ->assertSee($contact->customer->name);
    }
}
