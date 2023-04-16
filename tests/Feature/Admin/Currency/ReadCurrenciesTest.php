<?php

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant read currencies', function () {
    $this->get(route('admin.currencies.index'))
        ->assertRedirect(route('admin.login'));
});

test('user can read currencies', function () {
    [$eur, $usd] = Currency::factory()
        ->count(2)
        ->state(new Sequence(
            ['code' => 'EUR'],
            ['code' => 'USD']
        ))->create();

    $this->login()
        ->get(route('admin.currencies.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.currencies.index')
        ->assertViewHas('currencies')
        ->assertSeeInOrder([$eur->code, $usd->code]);
});
