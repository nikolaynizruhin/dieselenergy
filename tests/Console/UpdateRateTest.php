<?php

namespace Tests\Console;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UpdateRateTest extends TestCase
{
    /** @test */
    public function it_updates_currency_rates()
    {
        Http::fake([
            'api.minfin.com.ua/mb/'.config('services.minfin.key') => Http::response([
                [
                    'id' => '92150',
                    'pointDate' => '2020-10-16 17:20:28',
                    'date' => '2020-10-16 17:00:00',
                    'ask' => '33.2636',
                    'bid' => '33.2488',
                    'trendAsk' => '4.8986',
                    'trendBid' => '4.8988',
                    'currency' => 'eur',
                ],
                [
                    'id' => '92146',
                    'pointDate' => '2020-10-16 17:19:21',
                    'date' => '2020-10-16 17:00:00',
                    'ask' => '28.3650',
                    'bid' => '28.3500',
                    'trendAsk' => '-0.0100',
                    'trendBid' => '-0.0100',
                    'currency' => 'usd',
                ],
            ]),
        ]);

        $usd = Currency::factory()->create(['code' => 'USD', 'rate' => 25.0050]);
        $eur = Currency::factory()->create(['code' => 'EUR', 'rate' => 30.0025]);

        $this->artisan('rate:update')
            ->expectsTable(['Currency', 'Rate'], [['USD', 28.3650], ['EUR', 33.2636]])
            ->assertExitCode(Command::SUCCESS);

        Http::assertSent(fn ($request) => $request->url() == config('services.minfin.url').'/mb/'.config('services.minfin.key'));

        Http::assertSentCount(1);

        $this->assertEquals(28.3650, $usd->fresh()->rate);
        $this->assertEquals(33.2636, $eur->fresh()->rate);
    }
}
