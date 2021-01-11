<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateCurrency extends StoreCurrency
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'code' => [
                'required',
                'string',
                'size:3',
                Rule::unique('currencies')->ignore($this->currency),
            ],
            'symbol' => [
                'required',
                'string',
                Rule::unique('currencies')->ignore($this->currency),

            ],
        ]);
    }
}
