<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ReadContactsTest extends TestCase
{
    /** @test */
    public function guest_cant_read_contacts()
    {
        $this->get(route('admin.contacts.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_contacts()
    {
        [$contactSale, $contactSupport] = Contact::factory()
            ->count(2)
            ->state(new Sequence(
                ['message' => 'Support'],
                ['message' => 'Sale'],
            ))->create();

        $this->login()
            ->get(route('admin.contacts.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.index')
            ->assertViewHas('contacts')
            ->assertSeeInOrder([$contactSale->message, $contactSupport->message]);
    }
}
