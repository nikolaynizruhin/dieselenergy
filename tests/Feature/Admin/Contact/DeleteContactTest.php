<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_contact()
    {
        $contact = Contact::factory()->create();

        $this->delete(route('admin.contacts.destroy', $contact))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_contact()
    {
        $contact = Contact::factory()->create();

        $this->login()
            ->from(route('admin.contacts.index'))
            ->delete(route('admin.contacts.destroy', $contact))
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.deleted'));

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }
}
