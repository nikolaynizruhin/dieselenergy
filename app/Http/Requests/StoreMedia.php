<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMedia extends FormRequest
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
            'image_id' => 'required|numeric|exists:images,id',
            'product_id' => [
                'required',
                'numeric',
                'exists:products,id',
                Rule::unique('image_product')->where(fn ($query) => $query->where([
                    'image_id' => $this->image_id,
                ])),
            ],
        ];
    }
}
