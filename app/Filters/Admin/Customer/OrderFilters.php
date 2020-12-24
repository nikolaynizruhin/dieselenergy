<?php

namespace App\Filters\Admin\Customer;

use App\Filters\Filters;
use App\Filters\HasSort;

class OrderFilters extends Filters
{
    use HasSort {
        sort as sortBy;
    }

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
        if (isset($search['order'])) {
            $this->builder->where('id', 'like', '%'.$search['order'].'%');
        }
    }

    /**
     * Sort the query by a given user field.
     *
     * @param  string|array  $field
     * @return void
     */
    protected function sort($field)
    {
        if (isset($field['order'])) {
            $this->sortBy($field['order']);
        }
    }
}
