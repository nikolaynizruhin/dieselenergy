<?php

namespace App\Filters\Admin\Customer;

use App\Filters\Filters;
use App\Filters\HasSearch;
use App\Filters\HasSort;

class ContactFilters extends Filters
{
    use HasSort {
        sort as sortBy;
    }

    use HasSearch {
        search as searchBy;
    }

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
    protected string $search = 'message';

    /**
     * Filter the query by a given name.
     *
     * @param  array  $search
     * @return void
     */
    protected function search(array $search): void
    {
        if (isset($search['contact'])) {
            $this->searchBy($search['contact']);
        }
    }

    /**
     * Sort the query by a given user field.
     *
     * @param  string|array  $field
     * @return void
     */
    protected function sort($field): void
    {
        if (isset($field['contact'])) {
            $this->sortBy($field['contact']);
        }
    }
}
