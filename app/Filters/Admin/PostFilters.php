<?php

namespace App\Filters\Admin;

use App\Filters\Filters;

class PostFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['search'];

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
