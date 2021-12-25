<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreCategory extends FormRequest
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
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $this->isMethod(Request::METHOD_POST)
                    ? Rule::unique('categories')
                    : Rule::unique('categories')->ignore($this->category),
            ],
            'slug' => [
                'required',
                'string',
                'alpha_dash',
                'max:255',
                $this->isMethod(Request::METHOD_POST)
                    ? Rule::unique('categories')
                    : Rule::unique('categories')->ignore($this->category),
            ],
        ];
    }
}
