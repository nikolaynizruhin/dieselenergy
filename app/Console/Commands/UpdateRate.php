<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateRate extends Command
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
     *
     * @return int
     */
    public function handle()
    {
        $rates = Http::get('https://api.minfin.com.ua/mb/'.config('services.minfin.key'))->json();

        Currency::each(function ($currency) use ($rates) {
            $rate = collect($rates)->firstWhere('currency', strtolower($currency->code));

            $currency->update(['rate' => (float) $rate['ask']]);
        });

        $this->info('Currency rates updated successfully!');

        return 0;
    }
}
