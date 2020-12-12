<?php

namespace App\Filters\Admin;

use App\Filters\Filters;

class CurrencyFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['search'];

    /**
     * Filter the query by a given code.
     *
     * @param  string  $code
     * @return void
     */
    protected function search($code)
    {
        $this->builder->where('code', 'like', '%'.$code.'%');
    }
}
