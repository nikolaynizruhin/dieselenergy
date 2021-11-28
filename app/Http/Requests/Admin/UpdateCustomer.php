<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateCustomer extends StoreCustomer
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
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('customers')->ignore($this->customer),
                ],
            ],
        ];
    }
}
