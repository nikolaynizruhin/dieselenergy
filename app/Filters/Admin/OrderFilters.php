<?php

namespace App\Filters\Admin;

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
     * @param  string  $id
     * @return void
     */
    protected function search($id)
    {
        $this->builder->where('id', 'like', '%'.$id.'%');
    }
}
