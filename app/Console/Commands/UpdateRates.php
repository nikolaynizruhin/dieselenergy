<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Facades\App\Services\Minfin;
use Illuminate\Console\Command;

class UpdateRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rate:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currency rates';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $rates = Minfin::getRates();

        $currencies = Currency::all()->map(function ($currency) use ($rates) {
            $rate = $rates->firstWhere('currency', strtolower($currency->code));

            $currency->update(['rate' => (float) $rate['ask']]);

            return ['code' => $currency->code, 'rate' => $currency->rate];
        });

        $this->table(['Currency', 'Rate'], $currencies);

        return self::SUCCESS;
    }
}
