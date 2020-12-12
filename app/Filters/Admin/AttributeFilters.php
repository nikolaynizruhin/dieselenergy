<?php

namespace App\Filters\Admin;

use App\Filters\Filters;

class AttributeFilters extends Filters
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
     * @param  string  $name
     * @return void
     */
    protected function search($name)
    {
        $this->builder->where('name', 'like', '%'.$name.'%');
    }
}
