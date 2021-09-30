<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchContactsTest extends TestCase
{


    /** @test */
    public function guest_cant_search_contacts()
    {
        $contact = Contact::factory()->create();

        $this->get(route('admin.contacts.index', ['search' => $contact->message]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_contacts()
    {
        [$contactSale, $contactSupport, $contactOther] = Contact::factory()
            ->count(3)
            ->state(new Sequence(
                ['message' => 'Sale Contact'],
                ['message' => 'Support Contact'],
                ['message' => 'Other'],
            ))->create();

        $this->login()
            ->get(route('admin.contacts.index', ['search' => 'Contact']))
            ->assertSeeInOrder([$contactSale->message, $contactSupport->message])
            ->assertDontSee($contactOther->message);
    }
}
