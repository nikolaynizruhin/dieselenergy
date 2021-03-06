<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class StoreContact extends FormRequest
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
            'message' => 'nullable|string',
        ];
    }

    /**
     * Get validated customer attributes.
     *
     * @return array
     */
    public function getCustomerAttributes()
    {
        return $this->only(['name', 'phone']);
    }

    /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return parent::getRedirectUrl().'#contact';
    }
}
