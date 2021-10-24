<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateCustomerTest extends TestCase
{
    /** @test */
    public function guest_cant_visit_create_customer_page()
    {
        $this->get(route('admin.customers.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_customer_page()
    {
        $this->login()
            ->get(route('admin.customers.create'))
            ->assertViewIs('admin.customers.create');
    }

    /** @test */
    public function guest_cant_create_customer()
    {
        $this->post(route('admin.customers.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_customer()
    {
        $this->login()
            ->post(route('admin.customers.store'), $fields = $this->validFields())
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('status', trans('customer.created'));

        $this->assertDatabaseHas('customers', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_create_customer_with_invalid_data($field, $data, $count = 0)
    {
        $this->login()
            ->from(route('admin.customers.create'))
            ->post(route('admin.customers.store'), $data())
            ->assertRedirect(route('admin.customers.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('customers', $count);
    }

    public function validationProvider(): array
    {
        return [
            'Name is required' => [
                'name', fn () => $this->validFields(['name' => null]),
            ],
            'Name cant be an integer' => [
                'name', fn () => $this->validFields(['name' => 1]),
            ],
            'Name cant be more than 255 chars' => [
                'name', fn () => $this->validFields(['name' => Str::random(256)]),
            ],
            'Email is required' => [
                'email', fn () => $this->validFields(['email' => null]),
            ],
            'Email cant be an integer' => [
                'email', fn () => $this->validFields(['email' => 1]),
            ],
            'Email cant be more than 255 chars' => [
                'email', fn () => $this->validFields(['email' => Str::random(256)]),
            ],
            'Email must be valid' => [
                'email', fn () => $this->validFields(['email' => 'invalid']),
            ],
            'Email must be unique' => [
                'email', fn () => $this->validFields(['email' => Customer::factory()->create()->email]), 1,
            ],
            'Phone is required' => [
                'phone', fn () => $this->validFields(['phone' => null]),
            ],
            'Phone must have valid format' => [
                'phone', fn () => $this->validFields(['phone' => 0631234567]),
            ],
            'Notes cant be an integer' => [
                'notes', fn () => $this->validFields(['notes' => 1]),
            ],
        ];
    }

    /**
     * Get valid customer fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Customer::factory()->raw($overrides);
    }
}
