<?php

namespace App\Filters\Admin\Customer;

use App\Filters\Filters;

class OrderFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['search'];

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
}
