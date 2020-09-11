<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_contacts()
    {
        $contact = Contact::factory()->create();

        $this->get(route('admin.contacts.index', ['search' => $contact->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_contacts()
    {
        $user = User::factory()->create();

        $contactSale = Contact::factory()->create(['subject' => 'Sale Contact']);
        $contactSupport = Contact::factory()->create(['subject' => 'Support Contact']);
        $contactOther = Contact::factory()->create(['subject' => 'Other']);

        $this->actingAs($user)
            ->get(route('admin.contacts.index', ['search' => 'Contact']))
            ->assertSeeInOrder([$contactSale->subject, $contactSupport->subject])
            ->assertDontSee($contactOther->subject);
    }
}
