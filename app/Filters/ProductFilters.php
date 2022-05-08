<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilters extends Filters
{
    use HasSort;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected array $filters = ['search', 'attribute', 'sort'];

    /**
     * Filter the query by a given name.
     *
     * @param  string  $name
     * @return void
     */
    protected function search($name)
    {
        $this->builder->where('name', 'like', '%'.$name.'%');
    }

    /**
     * Filter the query by a given attributes.
     *
     * @param  array  $attributes
     * @return void
     */
    protected function attribute($attributes)
    {
        collect($attributes)->each(fn ($values, $id) => $this->builder
            ->whereHas('attributes', fn (Builder $query) => $query
                ->where('attribute_id', $id)
                ->whereIn('value', $values)
            )
        );
    }
}
