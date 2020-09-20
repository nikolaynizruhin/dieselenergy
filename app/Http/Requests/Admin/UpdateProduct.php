<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateProduct extends StoreProduct
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($this->product),
            ],
            'model' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($this->product),
            ],
            'slug' => [
                'required',
                'string',
                'alpha_dash',
                'max:255',
                Rule::unique('products')->ignore($this->product),
            ],
        ]);
    }
}
