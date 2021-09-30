<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchContactsTest extends TestCase
{


    /** @test */
    public function user_can_search_customer_contacts()
    {
        $customer = Customer::factory()->create();

        [$support, $faq, $sale] = Contact::factory()
            ->count(3)
            ->state(new Sequence(
                ['message' => 'Support Message', 'created_at' => now()->subDay()],
                ['message' => 'FAQ Message'],
                ['message' => 'Sale'],
            ))->create(['customer_id' => $customer->id]);

        $this->login()
            ->get(route('admin.customers.show', [
                'customer' => $customer,
                'search' => ['contact' => 'message'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$faq->message, $support->message])
            ->assertDontSee($sale->message);
    }
}
