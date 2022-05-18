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
    protected array $filters = ['search'];

    /**
     * Filter the query by a given name.
     *
     * @param  string  $path
     * @return void
     */
    protected function search(string $path): void
    {
        $this->builder->where('path', 'like', '%'.$path.'%');
    }
}
