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
    protected array $filters = ['search', 'sort'];

    /**
     * Filter the query by a given id.
     *
     * @param  string  $id
     * @return void
     */
    protected function search(string $id): void
    {
        $this->builder->where('orders.id', 'like', '%'.$id.'%');
    }
}
