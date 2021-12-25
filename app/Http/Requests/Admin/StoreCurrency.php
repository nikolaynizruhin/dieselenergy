<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreCurrency extends FormRequest
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
            'code' => [
                'required',
                'string',
                'size:3',
                $this->unique(),
            ],
            'symbol' => [
                'required',
                'string',
                $this->unique(),
            ],
            'rate' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get unique rule.
     *
     * @return \Illuminate\Validation\Rules\Unique
     */
    private function unique()
    {
        return $this->isMethod(Request::METHOD_POST)
            ? Rule::unique('currencies')
            : Rule::unique('currencies')->ignore($this->currency);
    }
}
