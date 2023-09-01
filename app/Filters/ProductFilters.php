<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilters extends Filters
{
    use HasSearch, HasSort;

    /**
     * Registered filters to operate upon.
     */
    protected array $filters = ['search', 'attribute', 'sort'];

    /**
     * Search field.
     */
    protected string $search = 'name';

    /**
     * Filter the query by a given attributes.
     */
    protected function attribute(array $attributes): void
    {
        collect($attributes)->each(fn ($values, $id) => $this->builder
            ->whereHas('attributes', fn (Builder $query) => $query
                ->where('attribute_id', $id)
                ->whereIn('value', $values)
            )
        );
    }
}
