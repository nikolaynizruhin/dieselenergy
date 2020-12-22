<?php

namespace App\Filters\Admin;

use App\Filters\Filters;
use Illuminate\Support\Str;

class CurrencyFilters extends Filters
{
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

    /**
     * Sort the query by a given user field.
     *
     * @param  string  $field
     * @return void
     */
    protected function sort($field)
    {
        $direction = Str::startsWith($field, '-') ? 'desc' : 'asc';

        $field = ltrim($field, '-');

        $this->builder->orderBy($field, $direction);
    }
}
