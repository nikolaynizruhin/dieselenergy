<?php

namespace App\Filters\Admin\Customer;

use App\Filters\Filters;

class ContactFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['search'];

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
}
