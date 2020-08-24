<?php

namespace Tests\Feature\Admin\Contact;

use App\Contact;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_contacts()
    {
        $contact = factory(Contact::class)->create();

        $this->get(route('admin.contacts.index', ['search' => $contact->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_contacts()
    {
        $user = factory(User::class)->create();

        $contactSale = factory(Contact::class)->create(['subject' => 'Sale Contact']);
        $contactSupport = factory(Contact::class)->create(['subject' => 'Support Contact']);
        $contactOther = factory(Contact::class)->create(['subject' => 'Other']);

        $this->actingAs($user)
            ->get(route('admin.contacts.index', ['search' => 'Contact']))
            ->assertSeeInOrder([$contactSale->subject, $contactSupport->subject])
            ->assertDontSee($contactOther->subject);
    }
}
