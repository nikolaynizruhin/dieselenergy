<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class FilterProducts extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Get sort column.
     *
     * @param  string  $default
     * @return string
     */
    public function column($default = 'name')
    {
        return $this->has('sort')
            ? ltrim($this->sort, '-')
            : $default;
    }

    /**
     * Get sort direction.
     *
     * @param  string  $default
     * @return string
     */
    public function direction($default = 'asc')
    {
        return $this->has('sort')
            ? Str::startsWith($this->sort, '-') ? 'desc' : 'asc'
            : $default;
    }
}