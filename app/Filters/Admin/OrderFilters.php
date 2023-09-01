<?php

namespace App\Filters\Admin;

use App\Filters\Filters;
use App\Filters\HasSearch;
use App\Filters\HasSort;

class OrderFilters extends Filters
{
    use HasSearch, HasSort;

    /**
     * Registered filters to operate upon.
     */
    protected array $filters = ['search', 'sort'];

    /**
     * Search field.
     */
    protected string $search = 'orders.id';
}
