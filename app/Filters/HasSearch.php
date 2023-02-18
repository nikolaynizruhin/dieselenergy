<?php

namespace App\Filters;

trait HasSearch
{
    /**
     * Filter the query by a given name.
     */
    protected function search(string $query): void
    {
        $this->builder->where($this->search, 'like', '%'.$query.'%');
    }
}
