<?php

namespace App\Filters\Admin;

use App\Filters\Filters;
use App\Filters\HasSort;

class OrderFilters extends Filters
{
    use HasSort;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['search', 'sort'];

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
