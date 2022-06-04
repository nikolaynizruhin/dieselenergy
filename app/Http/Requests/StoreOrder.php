<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Facades\App\Services\Cart;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
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
            'privacy' => 'accepted',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|regex:'.Customer::PHONE_REGEX,
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Get order attributes.
     *
     * @return array
     */
    public function getOrderAttributes(): array
    {
        return $this->only(['name', 'email', 'phone', 'notes']);
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (Cart::items()->isEmpty()) {
                $validator->errors()->add('cart', 'Кошик не повинен бути порожнім.');
            }
        });
    }
}
