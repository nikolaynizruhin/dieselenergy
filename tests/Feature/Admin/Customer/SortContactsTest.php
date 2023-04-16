<?php

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function () {
    $this->customer = Customer::factory()->create();
});

test('guest cant sort customer contacts', function () {
    $this->get(route('admin.customers.show', [
        'customer' => $this->customer,
        'sort' => ['contact' => 'message'],
    ]))->assertRedirect(route('admin.login'));
});

test('user can sort customer contacts by message ascending', function () {
    [$support, $faq] = Contact::factory()
        ->count(2)
        ->state(new Sequence(
            ['message' => 'Support Message'],
            ['message' => 'FAQ Message'],
        ))->create(['customer_id' => $this->customer->id]);

    $this->login()
        ->get(route('admin.customers.show', [
            'customer' => $this->customer,
            'sort' => ['contact' => 'message'],
        ]))->assertSuccessful()
        ->assertSeeInOrder([$faq->message, $support->message]);
});

test('user can sort customer contacts by message descending', function () {
    [$support, $faq] = Contact::factory()
        ->count(2)
        ->state(new Sequence(
            ['message' => 'Support Message'],
            ['message' => 'FAQ Message'],
        ))->create(['customer_id' => $this->customer->id]);

    $this->login()
        ->get(route('admin.customers.show', [
            'customer' => $this->customer,
            'sort' => ['contact' => '-message'],
        ]))->assertSuccessful()
        ->assertSeeInOrder([$support->message, $faq->message]);
});

test('user can sort customer contacts by date ascending', function () {
    [$support, $faq] = Contact::factory()
        ->count(2)
        ->state(new Sequence(
            ['created_at' => now()],
            ['created_at' => now()->subDay()],
        ))->create(['customer_id' => $this->customer->id]);

    $this->login()
        ->get(route('admin.customers.show', [
            'customer' => $this->customer,
            'sort' => ['contact' => 'created_at'],
        ]))->assertSuccessful()
        ->assertSeeInOrder([$faq->message, $support->message]);
});

test('user can sort customer contacts by date descending', function () {
    [$support, $faq] = Contact::factory()
        ->count(2)
        ->state(new Sequence(
            ['created_at' => now()],
            ['created_at' => now()->subDay()],
        ))->create(['customer_id' => $this->customer->id]);

    $this->login()
        ->get(route('admin.customers.show', [
            'customer' => $this->customer,
            'sort' => ['contact' => '-created_at'],
        ]))->assertSuccessful()
        ->assertSeeInOrder([$support->message, $faq->message]);
});
