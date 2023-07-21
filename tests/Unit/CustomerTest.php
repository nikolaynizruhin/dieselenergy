<?php

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

it('has many orders', function () {
    $customer = Customer::factory()
        ->hasOrders(1)
        ->create();

    expect($customer->orders)->toBeInstanceOf(Collection::class);
});
