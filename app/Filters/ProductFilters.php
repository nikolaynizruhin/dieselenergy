<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilters extends Filters
{
    use HasSort, HasSearch;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected array $filters = ['search', 'attribute', 'sort'];

    /**
     * Search field.
     *
     * @var string
     */
    protected string $search = 'name';

    /**
     * Filter the query by a given attributes.
     *
     * @param  array  $attributes
     * @return void
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
