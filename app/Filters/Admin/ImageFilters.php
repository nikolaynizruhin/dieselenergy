<?php

namespace App\Filters\Admin;

use App\Filters\Filters;

class ImageFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['search'];

    /**
     * Filter the query by a given name.
     *
     * @param  string  $path
     * @return void
     */
    protected function search($path)
    {
        $this->builder->where('path', 'like', '%'.$path.'%');
    }
}
