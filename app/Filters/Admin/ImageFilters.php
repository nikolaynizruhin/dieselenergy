<?php

namespace App\Filters\Admin;

use App\Filters\Filters;
use App\Filters\HasSearch;

class ImageFilters extends Filters
{
    use HasSearch;

    /**
     * Registered filters to operate upon.
     */
    protected array $filters = ['search'];

    /**
     * Search field.
     */
    protected string $search = 'path';
}
