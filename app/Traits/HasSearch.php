<?php

namespace App\Traits;

trait HasSearch
{
    /**
     * Scope a query to a searchable term.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $attribute
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $attribute, $search)
    {
        return $query->where($attribute, 'like', '%'.$search.'%');
    }
}
