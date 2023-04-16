<?php

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant search customers', function () {
    Customer::factory()->create(['name' => 'John Doe']);

    $this->get(route('admin.customers.index', ['search' => 'john']))
        ->assertRedirect(route('admin.login'));
});

test('user can search customers', function () {
    [$john, $jane, $tom] = Customer::factory()
        ->count(3)
        ->state(new Sequence(
            ['name' => 'John Doe', 'created_at' => now()->subDay()],
            ['name' => 'Jane Doe'],
            ['name' => 'Tom Jo'],
        ))->create();

    $this->login()
        ->get(route('admin.customers.index', ['search' => 'Doe']))
        ->assertSeeInOrder([$jane->email, $john->email])
        ->assertDontSee($tom->email);
});
