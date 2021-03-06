<?php

namespace App\Filters\Admin;

use App\Filters\Filters;
use App\Filters\HasSort;

class CustomerFilters extends Filters
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
     * @param  string  $name
     * @return void
     */
    protected function search($name)
    {
        $this->builder->where('name', 'like', '%'.$name.'%');
    }
}
