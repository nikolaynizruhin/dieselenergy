<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use Tests\TestCase;

class UpdateContactTest extends TestCase
{
    use HasValidation;

    /**
     * Contract.
     */
    private Contact $contact;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->contact = Contact::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_edit_contact_page(): void
    {
        $this->get(route('admin.contacts.edit', $this->contact))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_contact_page(): void
    {
        $this->login()
            ->get(route('admin.contacts.edit', $this->contact))
            ->assertViewIs('admin.contacts.edit');
    }

    /** @test */
    public function guest_cant_update_contact(): void
    {
        $this->put(route('admin.contacts.update', $this->contact), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_contact(): void
    {
        $this->login()
            ->put(route('admin.contacts.update', $this->contact), $fields = self::validFields())
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.updated'));

        $this->assertDatabaseHas('contacts', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_update_contact_with_invalid_data(string $field, callable $data): void
    {
        $this->login()
            ->from(route('admin.contacts.edit', $this->contact))
            ->put(route('admin.contacts.update', $this->contact), $data())
            ->assertRedirect(route('admin.contacts.edit', $this->contact))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('contacts', 1);
    }
}
