<?php

namespace App\Filters\Admin;

use App\Filters\Filters;
use App\Filters\HasSort;

class CurrencyFilters extends Filters
{
    use HasSort;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['search', 'sort'];

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
