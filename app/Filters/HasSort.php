<?php

namespace App\Filters;

trait HasSort
{
    /**
     * Sort the query by a given user field.
     */
    protected function sort(string $field): void
    {
        $direction = str_starts_with($field, '-') ? 'desc' : 'asc';

        $field = ltrim($field, '-');

        $this->builder->orderBy($field, $direction);
    }
}
