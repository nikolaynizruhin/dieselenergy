<?php

namespace App\Filters\Admin\Customer;

use App\Filters\Filters;
use App\Filters\HasSearch;
use App\Filters\HasSort;

class OrderFilters extends Filters
{
    use HasSort {
        sort as sortBy;
    }
    use HasSearch {
        search as searchBy;
    }

    /**
     * Registered filters to operate upon.
     */
    protected array $filters = ['search', 'sort'];

    /**
     * Search field.
     */
    protected string $search = 'id';

    /**
     * Filter the query by a given id.
     */
    protected function search(array $search): void
    {
        if (isset($search['order'])) {
            $this->searchBy($search['order']);
        }
    }

    /**
     * Sort the query by a given user field.
     */
    protected function sort(string|array $field): void
    {
        if (isset($field['order'])) {
            $this->sortBy($field['order']);
        }
    }
}
