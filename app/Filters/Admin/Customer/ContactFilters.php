<?php

namespace App\Filters\Admin\Customer;

use App\Filters\Filters;
use Illuminate\Support\Str;

class ContactFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['search', 'sort'];

    /**
     * Filter the query by a given name.
     *
     * @param  array  $search
     * @return void
     */
    protected function search($search)
    {
        $message = $search['contact'] ?? '';

        $this->builder->where('message', 'like', '%'.$message.'%');
    }

    /**
     * Sort the query by a given user field.
     *
     * @param  string|array  $field
     * @return void
     */
    protected function sort($field)
    {
        $field = $field['contact'] ?? null;

        $direction = Str::startsWith($field, '-') ? 'desc' : 'asc';

        $field = ltrim($field, '-');

        $this->builder->orderBy($field, $direction);
    }
}
