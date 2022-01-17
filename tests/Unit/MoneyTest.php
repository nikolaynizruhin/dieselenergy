<?php

namespace Tests\Unit;

use App\Models\Currency;
use App\Support\Money;
use Tests\TestCase;

class MoneyTest extends TestCase
{
    /**
     * Money.
     *
     * @var \App\Support\Money
     */
    private $money;

    protected function setUp(): void
    {
        parent::setUp();

        $this->money = new Money(10000);
    }

    /** @test */
    public function it_can_get_coins()
    {
        $this->assertEquals(10000, $this->money->coins());
    }

    /** @test */
    public function it_can_get_decimal()
    {
        $this->assertEquals(100.00, $this->money->decimal());
    }

    /** @test */
    public function it_can_be_formatted()
    {
        $this->assertEquals('100 ₴', $this->money->format());
    }

    /** @test */
    public function it_can_be_formatted_with_currency()
    {
        $currency = Currency::factory()->create(['symbol' => '$']);
        $money = new Money(10000, $currency);

        $this->assertEquals('100 $', $money->format());
    }

    /** @test */
    public function it_can_be_converted_to_uah()
    {
        $currency = Currency::factory()->create(['rate' => 33.3057]);
        $money = new Money(10000, $currency);

        $this->assertEquals(333057, $money->toUAH()->coins());
    }
}
