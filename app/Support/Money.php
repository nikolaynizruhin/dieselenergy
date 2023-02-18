<?php

namespace App\Support;

use App\Models\Currency;

class Money
{
    /**
     * Default currency symbol.
     *
     * @var string
     */
    const DEFAULT_SYMBOL = '₴';

    /**
     * Money constructor.
     */
    public function __construct(
        private int $coins,
        private ?Currency $currency = null
    ) {
    }

    /**
     * Get money in coins.
     */
    public function coins(): int
    {
        return $this->coins;
    }

    /**
     * Get money in coins.
     */
    public function decimal(): string
    {
        return number_format($this->coins / 100, 2, '.', '');
    }

    /**
     * Get uah formatted money.
     */
    public function format(): string
    {
        $symbol = $this->currency->symbol ?? self::DEFAULT_SYMBOL;

        return number_format($this->coins / 100, 0, '.', ' ').' '.$symbol;
    }

    /**
     * Convert currency to UAH.
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
