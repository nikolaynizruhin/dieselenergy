<?php

namespace App\Filters\Admin;

use App\Filters\Filters;
use App\Filters\HasSort;

class ContactFilters extends Filters
{
    use HasSort;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['search', 'sort'];

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
