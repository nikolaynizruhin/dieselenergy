<?php

namespace App\Services;

use Illuminate\Http\Client\Factory;

class Minfin
{
    /**
     * Http client.
     *
     * @var \Illuminate\Http\Client\PendingRequest
     */
    private $http;

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
     * @return array|mixed
     */
    public function getRates()
    {
        return $this->http->get('/mb/'.config('services.minfin.key'))->collect();
    }
}
