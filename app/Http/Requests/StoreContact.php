<?php

namespace App\Http\Requests;

use App\Rules\Phone;
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
            'phone' => ['required', new Phone],
            'message' => 'nullable|string',
        ];
    }

    /**
     * Get validated customer attributes.
     */
    public function getContactAttributes(): array
    {
        return $this->only(['name', 'phone', 'email', 'message']);
    }

    /**
     * Get the URL to redirect to on a validation error.
     */
    protected function getRedirectUrl(): string
    {
        return parent::getRedirectUrl().'#contact';
    }
}
