<?php

namespace Tests\Unit;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    /** @test */
    public function it_has_many_brands(): void
    {
        $currency = Currency::factory()
            ->hasBrands(1)
            ->create();

        $this->assertInstanceOf(Collection::class, $currency->brands);
    }
}
