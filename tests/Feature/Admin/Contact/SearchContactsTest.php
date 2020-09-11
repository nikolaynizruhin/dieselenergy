<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        [$contactSale, $contactSupport, $contactOther] = Contact::factory()
            ->count(3)
            ->state(new Sequence(
                ['subject' => 'Sale Contact'],
                ['subject' => 'Support Contact'],
                ['subject' => 'Other'],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.contacts.index', ['search' => 'Contact']))
            ->assertSeeInOrder([$contactSale->subject, $contactSupport->subject])
            ->assertDontSee($contactOther->subject);
    }
}
