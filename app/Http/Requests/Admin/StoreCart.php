<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreCart extends FormRequest
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
            'order_id' => 'required|numeric|exists:orders,id',
            'quantity' => 'required|numeric|min:1',
            'product_id' => [
                'required',
                'numeric',
                'exists:products,id',
                $this->unique(),
            ],
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
            ? Rule::unique('order_product')->where('order_id', $this->order_id)
            : Rule::unique('order_product')->ignore($this->cart)->where('order_id', $this->order_id);
    }
}
