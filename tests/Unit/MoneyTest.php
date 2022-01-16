<?php

namespace Tests\Unit;

use App\Models\Currency;
use App\Support\Money;
use Tests\TestCase;

class MoneyTest extends TestCase
{
    /** @test */
    public function it_can_get_coins()
    {
        $money = new Money(500);

        $this->assertEquals(500, $money->coins());
    }

    /** @test */
    public function it_can_get_decimal()
    {
        $money = new Money(500);

        $this->assertEquals(5.00, $money->decimal());
    }

    /** @test */
    public function it_can_get_uah()
    {
        $money = new Money(5000);

        $this->assertEquals('50 ₴', $money->format());
    }

    /** @test */
    public function it_can_be_converted_to_uah()
    {
        $currency = Currency::factory()->create(['rate' => 33.3057]);
        $money = new Money(10000, $currency);

        $this->assertEquals(333057, $money->toUAH()->coins());
    }
}
