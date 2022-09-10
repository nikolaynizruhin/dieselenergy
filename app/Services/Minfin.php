<?php

namespace App\Services;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;

class Minfin
{
    /**
     * Http client.
     *
     * @var \Illuminate\Http\Client\PendingRequest
     */
    private PendingRequest $http;

    /**
     * Minfin constructor.
     *
     * @return void
     */
    public function __construct(Factory $http)
    {
        $this->http = $http->withOptions(['base_uri' => config('services.minfin.url')]);
    }

    /**
     * Get currency rates.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRates(): Collection
    {
        return $this->http->get('/mb/'.config('services.minfin.key'))->collect();
    }
}
