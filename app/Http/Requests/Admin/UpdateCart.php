<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateCart extends StoreCart
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'product_id' => [
                'required',
                'numeric',
                'exists:products,id',
                Rule::unique('order_product')
                    ->ignore($this->cart)
                    ->where('order_id', $this->order_id),
            ],
        ]);
    }
}
