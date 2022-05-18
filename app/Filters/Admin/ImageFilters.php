<?php

namespace App\Filters\Admin;

use App\Filters\Filters;
use App\Filters\HasSearch;

class ImageFilters extends Filters
{
    use HasSearch;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected array $filters = ['search'];

    /**
     * Search field.
     *
     * @var string
     */
    protected string $search = 'path';
}
