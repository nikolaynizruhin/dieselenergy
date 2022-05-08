<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

trait HasUniqueRule
{
    /**
     * Get unique rule.
     *
     * @return \Illuminate\Validation\Rules\Unique
     */
    protected function unique($field): Unique
    {
        $rule = Rule::unique(Str::plural($field));

        return $this->isMethod(Request::METHOD_POST) ? $rule : $rule->ignore($this->{$field});
    }
}
