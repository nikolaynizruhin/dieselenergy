<?php

namespace Tests\Feature\Admin\Contact;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_sort_contacts()
    {
        $this->get(route('admin.contacts.index', ['sort' => 'created_at']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_contacts_by_date_ascending()
    {
        [$adam, $tom] = Contact::factory()
            ->count(2)
            ->state(new Sequence(
                ['created_at' => now()],
                ['created_at' => now()->subDay()],
            ))->create();

        $this->login()
            ->get(route('admin.contacts.index', ['sort' => 'created_at']))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.index')
            ->assertViewHas('contacts')
            ->assertSeeInOrder([$tom->message, $adam->message]);
    }

    /** @test */
    public function admin_can_sort_contacts_by_date_descending()
    {
        [$adam, $tom] = Contact::factory()
            ->count(2)
            ->state(new Sequence(
                ['created_at' => now()],
                ['created_at' => now()->subDay()],
            ))->create();

        $this->login()
            ->get(route('admin.contacts.index', ['sort' => '-created_at']))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.index')
            ->assertViewHas('contacts')
            ->assertSeeInOrder([$adam->message, $tom->message]);
    }

    /** @test */
    public function admin_can_sort_contacts_by_message_ascending()
    {
        [$adam, $tom] = Contact::factory()
            ->count(2)
            ->state(new Sequence(
                ['message' => 'hey'],
                ['message' => 'hello'],
            ))->create();

        $this->login()
            ->get(route('admin.contacts.index', ['sort' => 'message']))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.index')
            ->assertViewHas('contacts')
            ->assertSeeInOrder([$tom->message, $adam->message]);
    }

    /** @test */
    public function admin_can_sort_contacts_by_message_descending()
    {
        [$adam, $tom] = Contact::factory()
            ->count(2)
            ->state(new Sequence(
                ['message' => 'hey'],
                ['message' => 'hello'],
            ))->create();

        $this->login()
            ->get(route('admin.contacts.index', ['sort' => '-message']))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.index')
            ->assertViewHas('contacts')
            ->assertSeeInOrder([$adam->message, $tom->message]);
    }

    /** @test */
    public function admin_can_sort_contacts_by_customer_ascending()
    {
        [$adam, $tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Adam'],
                ['name' => 'Tom'],
            ))->create();

        Contact::factory()
            ->count(2)
            ->state(new Sequence(
                ['customer_id' => $adam],
                ['customer_id' => $tom],
            ))->create();

        $this->login()
            ->get(route('admin.contacts.index', ['sort' => 'customers.name']))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.index')
            ->assertViewHas('contacts')
            ->assertSeeInOrder([$adam->name, $tom->name]);
    }

    /** @test */
    public function admin_can_sort_contacts_by_customer_descending()
    {
        [$adam, $tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Adam'],
                ['name' => 'Tom'],
            ))->create();

        Contact::factory()
            ->count(2)
            ->state(new Sequence(
                ['customer_id' => $adam],
                ['customer_id' => $tom],
            ))->create();

        $this->login()
            ->get(route('admin.contacts.index', ['sort' => '-customers.name']))
            ->assertSuccessful()
            ->assertViewIs('admin.contacts.index')
            ->assertViewHas('contacts')
            ->assertSeeInOrder([$tom->name, $adam->name]);
    }
}
