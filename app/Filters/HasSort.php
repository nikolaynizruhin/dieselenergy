<?php

namespace App\Filters;

use Illuminate\Support\Str;

trait HasSort
{
    /**
     * Sort the query by a given user field.
     *
     * @param  string  $field
     * @return void
     */
    protected function sort(string $field): void
    {
        $direction = Str::startsWith($field, '-') ? 'desc' : 'asc';

        $field = ltrim($field, '-');

        $this->builder->orderBy($field, $direction);
    }
}
