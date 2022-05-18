<?php

namespace App\Filters\Admin;

use App\Filters\Filters;
use App\Filters\HasSearch;
use App\Filters\HasSort;

class OrderFilters extends Filters
{
    use HasSort, HasSearch;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected array $filters = ['search', 'sort'];

    /**
     * Search field.
     *
     * @var string
     */
    protected string $search = 'orders.id';
}
