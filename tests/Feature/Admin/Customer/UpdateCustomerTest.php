<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use Tests\TestCase;

class UpdateCustomerTest extends TestCase
{
    use HasValidation;

    /**
     * Customer.
     */
    private Customer $customer;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = Customer::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_customer_page(): void
    {
        $this->get(route('admin.customers.edit', $this->customer))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_customer_page(): void
    {
        $this->login()
            ->get(route('admin.customers.edit', $this->customer))
            ->assertViewIs('admin.customers.edit');
    }

    /** @test */
    public function guest_cant_update_customer(): void
    {
        $this->put(route('admin.customers.update', $this->customer), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_customer(): void
    {
        $this->login()
            ->put(route('admin.customers.update', $this->customer), $fields = self::validFields())
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('status', trans('customer.updated'));

        $this->assertDatabaseHas('customers', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_update_customer_with_invalid_data(string $field, callable $data, int $count = 1): void
    {
        $this->login()
            ->from(route('admin.customers.edit', $this->customer))
            ->put(route('admin.customers.update', $this->customer), $data())
            ->assertRedirect(route('admin.customers.edit', $this->customer))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('customers', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider(2);
    }
}
