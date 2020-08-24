<?php

namespace Tests\Feature\Admin\Contact;

use App\Brand;
use App\Contact;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $user = factory(User::class)->create();

        $contactSale = factory(Contact::class)->create(['subject' => 'Sale']);
        $contactSupport = factory(Contact::class)->create(['subject' => 'Support']);

        $this->actingAs($user)
            ->get(route('admin.contacts.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.index')
            ->assertViewHas('contacts')
            ->assertSeeInOrder([$contactSale->name, $contactSupport->name]);
    }
}
