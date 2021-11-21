<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use Tests\TestCase;

class DeleteContactTest extends TestCase
{
    /**
     * Category.
     *
     * @var \App\Models\Contact
     */
    private $contact;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->contact = Contact::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_contact()
    {
        $this->delete(route('admin.contacts.destroy', $this->contact))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_contact()
    {
        $this->login()
            ->from(route('admin.contacts.index'))
            ->delete(route('admin.contacts.destroy', $this->contact))
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.deleted'));

        $this->assertDeleted($this->contact);
    }
}
