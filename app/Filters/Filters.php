<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * The Eloquent builder.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected Builder $builder;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected array $filters = [];

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __construct(readonly protected Request $request)
    {
    }

    /**
     * Apply the filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
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
     *
     * @return array
     */
    public function getFilters(): array
    {
        return array_filter($this->request->only($this->filters));
    }
}
