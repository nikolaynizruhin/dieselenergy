<?php

namespace App\Filters\Admin\Customer;

use App\Filters\Filters;
use Illuminate\Support\Str;

class OrderFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['search', 'sort'];

    /**
     * Filter the query by a given id.
     *
     * @param  array  $search
     * @return void
     */
    protected function search($search)
    {
        $id = $search['order'] ?? '';

        $this->builder->where('id', 'like', '%'.$id.'%');
    }

    /**
     * Sort the query by a given user field.
     *
     * @param  string|array  $field
     * @return void
     */
    protected function sort($field)
    {
        $field = $field['order'] ?? null;

        $direction = Str::startsWith($field, '-') ? 'desc' : 'asc';

        $field = ltrim($field, '-');

        $this->builder->orderBy($field, $direction);
    }
}
