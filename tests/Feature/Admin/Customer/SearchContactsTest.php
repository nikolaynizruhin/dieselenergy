<?php

namespace Tests\Feature\Admin\Customer;

use App\Contact;
use App\Customer;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_customer_contacts()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->create();

        $support = factory(Contact::class)->create([
            'customer_id' => $customer->id,
            'subject' => 'Support Subject',
            'created_at' => now()->subDay(),
        ]);

        $faq = factory(Contact::class)->create([
            'customer_id' => $customer->id,
            'subject' => 'FAQ Subject',
            'created_at' => now(),
        ]);

        $sale = factory(Contact::class)->create([
            'customer_id' => $customer->id,
            'subject' => 'Sale'
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
