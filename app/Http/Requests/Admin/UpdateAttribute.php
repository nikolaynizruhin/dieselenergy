<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateAttribute extends StoreAttribute
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ...parent::rules(),
            ...[
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('attributes')->ignore($this->attribute),
                ],
            ],
        ];
    }
}
