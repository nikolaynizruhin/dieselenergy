<?php

namespace Tests\Feature\Admin\Contact;

use App\Brand;
use App\Contact;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_contact()
    {
        $contact = factory(Contact::class)->create();

        $this->delete(route('admin.contacts.destroy', $contact))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_contact()
    {
        $user = factory(User::class)->create();
        $contact = factory(Contact::class)->create();

        $this->actingAs($user)
            ->from(route('admin.contacts.index'))
            ->delete(route('admin.contacts.destroy', $contact))
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.deleted'));

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }
}