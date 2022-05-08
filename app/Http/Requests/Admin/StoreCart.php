<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

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
    private function unique(): Unique
    {
        $rule = Rule::unique('order_product')->where('order_id', $this->order_id);

        return $this->isMethod(Request::METHOD_POST) ? $rule : $rule->ignore($this->cart);
    }
}
