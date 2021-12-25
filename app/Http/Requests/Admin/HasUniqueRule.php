<?php

namespace App\Http\Requests\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

trait HasUniqueRule
{
    /**
     * Get unique rule.
     *
     * @return \Illuminate\Validation\Rules\Unique
     */
    protected function unique($field)
    {
        $rule = Rule::unique(Str::plural($field));

        return $this->isMethod(Request::METHOD_POST) ? $rule : $rule->ignore($this->{$field});
    }
}
