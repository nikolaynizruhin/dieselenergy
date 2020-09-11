<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_contacts()
    {
        $this->get(route('admin.contacts.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_contacts()
    {
        $user = User::factory()->create();

        $contactSale = Contact::factory()->create(['subject' => 'Sale']);
        $contactSupport = Contact::factory()->create(['subject' => 'Support']);

        $this->actingAs($user)
            ->get(route('admin.contacts.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.index')
            ->assertViewHas('contacts')
            ->assertSeeInOrder([$contactSale->name, $contactSupport->name]);
    }
}
