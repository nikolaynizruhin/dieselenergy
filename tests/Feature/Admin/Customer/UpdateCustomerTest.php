<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateCustomerTest extends TestCase
{
    use HasValidation;

    /**
     * Product.
     *
     * @var \App\Models\Customer
     */
    private $customer;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = Customer::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_customer_page()
    {
        $this->get(route('admin.customers.edit', $this->customer))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_customer_page()
    {
        $this->login()
            ->get(route('admin.customers.edit', $this->customer))
            ->assertViewIs('admin.customers.edit');
    }

    /** @test */
    public function guest_cant_update_customer()
    {
        $this->put(route('admin.customers.update', $this->customer), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_customer()
    {
        $this->login()
            ->put(route('admin.customers.update', $this->customer), $fields = $this->validFields())
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('status', trans('customer.updated'));

        $this->assertDatabaseHas('customers', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_customer_with_invalid_data($field, $data, $count = 1)
    {
        $this->login()
            ->from(route('admin.customers.edit', $this->customer))
            ->put(route('admin.customers.update', $this->customer), $data())
            ->assertRedirect(route('admin.customers.edit', $this->customer))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('customers', $count);
    }

    public function validationProvider()
    {
        return $this->provider(2);
    }
}
