<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Apply filters.
     */
    public function scopeFilter(Builder $query, Filters $filters): Builder
    {
        return $filters->apply($query);
    }
}
