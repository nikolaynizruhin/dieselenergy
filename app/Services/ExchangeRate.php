<?php

namespace App\Services;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;

class ExchangeRate
{
    /**
     * Http client.
     */
    private PendingRequest $http;

    /**
     * ExchangeRate constructor.
     *
     * @return void
     */
    public function __construct(Factory $http)
    {
        $this->http = $http->withOptions(['base_uri' => config('services.minfin.url')]);
    }

    /**
     * Get currency rates.
     */
    public function get(): Collection
    {
        return $this->http->get('/mb/'.config('services.minfin.key'))->collect();
    }
}
