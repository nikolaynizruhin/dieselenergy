<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCurrency extends FormRequest
{
    use HasUniqueRule;

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
                $this->unique('currency'),
            ],
            'symbol' => [
                'required',
                'string',
                $this->unique('currency'),
            ],
            'rate' => 'required|numeric|min:0',
        ];
    }
}
