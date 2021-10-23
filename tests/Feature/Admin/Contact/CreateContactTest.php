<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use Tests\TestCase;

class CreateContactTest extends TestCase
{
    /** @test */
    public function guest_cant_visit_create_contact_page()
    {
        $this->get(route('admin.contacts.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_contact_page()
    {
        $this->login()
            ->get(route('admin.contacts.create'))
            ->assertViewIs('admin.contacts.create');
    }

    /** @test */
    public function guest_cant_create_contact()
    {
        $this->post(route('admin.contacts.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_contact()
    {
        $this->login()
            ->post(route('admin.contacts.store'), $fields = $this->validFields())
            ->assertRedirect(route('admin.contacts.index'))
            ->assertSessionHas('status', trans('contact.created'));

        $this->assertDatabaseHas('contacts', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_create_contact_with_invalid_data($field, $data)
    {
        $this->login()
            ->from(route('admin.contacts.create'))
            ->post(route('admin.contacts.store'), $data())
            ->assertRedirect(route('admin.contacts.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('contacts', 0);
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
                'customer_id', fn () => $this->validFields(['customer_id' => 1]),
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
