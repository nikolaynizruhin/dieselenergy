<?php

namespace App\Support;

use App\Models\Currency;

class Money
{
    public function __construct(
        private int $coins,
        private ?Currency $currency = null
    ) {
    }

    /**
     * Get money in coins.
     *
     * @return int
     */
    public function coins(): int
    {
        return $this->coins;
    }

    /**
     * Get money in coins.
     *
     * @return string
     */
    public function decimal(): string
    {
        return number_format($this->coins / 100, 2, '.', '');
    }

    /**
     * Get uah formatted money.
     *
     * @return string
     */
    public function format(): string
    {
        $symbol = $this->currency->symbol ?? '₴';

        return number_format($this->coins / 100, 0, '.', ' ').' '.$symbol;
    }

    /**
     * Convert currency to UAH.
     *
     * @return static
     */
    public function toUAH(): static
    {
        if ($this->currency) {
            $this->coins = intval($this->coins * $this->currency->rate);
            $this->currency = null;
        }

        return $this;
    }
}
