<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use Tests\TestCase;

class UpdateContactTest extends TestCase
{
    /**
     * Product.
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
    public function guest_cant_visit_edit_contact_page()
    {
        $this->get(route('admin.contacts.edit', $this->contact))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_contact_page()
    {
        $this->login()
            ->get(route('admin.contacts.edit', $this->contact))
            ->assertViewIs('admin.contacts.edit');
    }

    /** @test */
    public function guest_cant_update_contact()
    {
        $this->put(route('admin.contacts.update', $this->contact), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_contact()
    {
        $this->login()
            ->put(route('admin.contacts.update', $this->contact), $fields = $this->validFields())
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.updated'));

        $this->assertDatabaseHas('contacts', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_contact_with_invalid_data($field, $data)
    {
        $this->login()
            ->from(route('admin.contacts.edit', $this->contact))
            ->put(route('admin.contacts.update', $this->contact), $data())
            ->assertRedirect(route('admin.contacts.edit', $this->contact))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('contacts', 1);
    }

    public function validationProvider(): array
    {
        return [
            'Message cant be an integer' => [
                'message', fn () => $this->validFields(['message' => 1]),
            ],
            'Customer is required' => [
                'customer_id', fn () => $this->validFields(['customer_id' => null]),
            ],
            'Customer cant be string' => [
                'customer_id', fn () => $this->validFields(['customer_id' => 'string']),
            ],
            'Customer must exists' => [
                'customer_id', fn () => $this->validFields(['customer_id' => 10]),
            ],
        ];
    }

    /**
     * Get valid contact fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Contact::factory()->raw($overrides);
    }
}
