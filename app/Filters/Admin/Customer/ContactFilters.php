<?php

namespace App\Filters\Admin\Customer;

use App\Filters\Filters;
use App\Filters\HasSearch;
use App\Filters\HasSort;

class ContactFilters extends Filters
{
    use HasSearch {
        search as searchBy;
    }
    use HasSort {
        sort as sortBy;
    }

    /**
     * Registered filters to operate upon.
     */
    protected array $filters = ['search', 'sort'];

    /**
     * Search field.
     */
    protected string $search = 'message';

    /**
     * Filter the query by a given name.
     */
    protected function search(array $search): void
    {
        if (isset($search['contact'])) {
            $this->searchBy($search['contact']);
        }
    }

    /**
     * Sort the query by a given user field.
     */
    protected function sort(string|array $field): void
    {
        if (isset($field['contact'])) {
            $this->sortBy($field['contact']);
        }
    }
}
