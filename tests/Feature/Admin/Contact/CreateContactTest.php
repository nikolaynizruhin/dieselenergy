<?php

namespace Tests\Feature\Admin\Contact;

use Tests\TestCase;

class CreateContactTest extends TestCase
{
    use HasValidation;

    /** @test */
    public function guest_cant_visit_create_contact_page(): void
    {
        $this->get(route('admin.contacts.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_contact_page(): void
    {
        $this->login()
            ->get(route('admin.contacts.create'))
            ->assertViewIs('admin.contacts.create');
    }

    /** @test */
    public function guest_cant_create_contact(): void
    {
        $this->post(route('admin.contacts.store'), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_contact(): void
    {
        $this->login()
            ->post(route('admin.contacts.store'), $fields = self::validFields())
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.created'));

        $this->assertDatabaseHas('contacts', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_create_contact_with_invalid_data(string $field, callable $data): void
    {
        $this->login()
            ->from(route('admin.contacts.create'))
            ->post(route('admin.contacts.store'), $data())
            ->assertRedirect(route('admin.contacts.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('contacts', 0);
    }
}
