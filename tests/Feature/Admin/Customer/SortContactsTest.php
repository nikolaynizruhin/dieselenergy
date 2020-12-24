<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Contact;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortContactsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Support contact.
     *
     * @var \App\Models\Contact
     */
    private $support;

    /**
     * FAQ contact.
     *
     * @var \App\Models\Contact
     */
    private $faq;

    /**
     * Customer.
     *
     * @var \App\Models\Customer
     */
    private $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = Customer::factory()->create();

        [$this->support, $this->faq] = Contact::factory()
            ->count(2)
            ->state(new Sequence(
                ['message' => 'Support Message'],
                ['message' => 'FAQ Message'],
            ))->create(['customer_id' => $this->customer->id]);
    }

    /** @test */
    public function guest_cant_sort_customer_contacts()
    {
        $this->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['contact' => 'message'],
            ]))->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_sort_customer_contacts_ascending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['contact' => 'message'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$this->faq->message, $this->support->message]);
    }

    /** @test */
    public function user_can_sort_customer_contacts_descending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['contact' => '-message'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$this->support->message, $this->faq->message]);
    }
}
