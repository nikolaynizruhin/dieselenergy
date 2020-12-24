<?php

namespace App\Filters\Admin\Customer;

use App\Filters\Filters;
use App\Filters\HasSort;

class ContactFilters extends Filters
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
     * Filter the query by a given name.
     *
     * @param  array  $search
     * @return void
     */
    protected function search($search)
    {
        if (isset($search['contact'])) {
            $this->builder->where('message', 'like', '%'.$search['contact'].'%');
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
        if (isset($field['contact'])) {
            $this->sortBy($field['contact']);
        }
    }
}
