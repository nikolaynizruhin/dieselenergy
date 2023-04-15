<?php

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant search currencies', function () {
    $currency = Currency::factory()->create();

    $this->get(route('admin.currencies.index', ['search' => $currency->code]))
        ->assertRedirect(route('admin.login'));
});

test('user can search currencies', function () {
    [$usd, $eur, $rub] = Currency::factory()
        ->count(3)
        ->state(new Sequence(
            ['code' => 'USD'],
            ['code' => 'EUR'],
            ['code' => 'RUB'],
        ))->create();

    $this->login()
        ->get(route('admin.currencies.index', ['search' => 'R']))
        ->assertSeeInOrder([$eur->code, $rub->code])
        ->assertDontSee($usd->code);
});
