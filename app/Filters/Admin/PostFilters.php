<?php

namespace App\Filters\Admin;

use App\Filters\Filters;
use Illuminate\Support\Str;

class PostFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['search', 'sort'];

    /**
     * Filter the query by a given title.
     *
     * @param  string  $title
     * @return void
     */
    protected function search($title)
    {
        $this->builder->where('title', 'like', '%'.$title.'%');
    }

    /**
     * Sort the query by a given user field.
     *
     * @param  string  $field
     * @return void
     */
    protected function sort($field)
    {
        $direction = Str::startsWith($field, '-') ? 'desc' : 'asc';

        $field = ltrim($field, '-');

        $this->builder->orderBy($field, $direction);
    }
}
