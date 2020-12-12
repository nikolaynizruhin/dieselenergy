<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Apply filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Filters\Filters  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, Filters $filters)
    {
        return $filters->apply($query);
    }
}
