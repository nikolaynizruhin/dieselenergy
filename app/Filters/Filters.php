<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * The Eloquent builder.
     */
    protected Builder $builder;

    /**
     * Registered filters to operate upon.
     */
    protected array $filters = [];

    /**
     * Create a new instance.
     */
    public function __construct(protected readonly Request $request) {}

    /**
     * Apply the filters.
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Fetch all relevant filters from the request.
     */
    public function getFilters(): array
    {
        return array_filter($this->request->only($this->filters));
    }
}
