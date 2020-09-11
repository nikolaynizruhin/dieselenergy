<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Contact;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_customer_contacts()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $support = Contact::factory()->create([
            'customer_id' => $customer->id,
            'subject' => 'Support Subject',
            'created_at' => now()->subDay(),
        ]);

        $faq = Contact::factory()->create([
            'customer_id' => $customer->id,
            'subject' => 'FAQ Subject',
            'created_at' => now(),
        ]);

        $sale = Contact::factory()->create([
            'customer_id' => $customer->id,
            'subject' => 'Sale',
        ]);

        $this->actingAs($user)
            ->get(route('admin.customers.show', [
                'customer' => $customer,
                'search' => ['contact' => 'subject'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$faq->subject, $support->subject])
            ->assertDontSee($sale->subject);
    }
}
