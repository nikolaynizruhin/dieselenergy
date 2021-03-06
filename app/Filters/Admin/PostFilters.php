<?php

namespace App\Filters\Admin;

use App\Filters\Filters;
use App\Filters\HasSort;

class PostFilters extends Filters
{
    use HasSort;

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
}
