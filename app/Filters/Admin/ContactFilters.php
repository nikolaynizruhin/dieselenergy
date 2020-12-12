<?php

namespace App\Filters\Admin;

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
     * @param  string  $message
     * @return void
     */
    protected function search($message)
    {
        $this->builder->where('message', 'like', '%'.$message.'%');
    }
}
