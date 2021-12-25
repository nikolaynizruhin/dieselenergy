<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                $this->unique(),
            ],
        ];

        if ($this->isMethod(Request::METHOD_POST)) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }

    /**
     * Get unique rule.
     *
     * @return \Illuminate\Validation\Rules\Unique
     */
    private function unique()
    {
        return $this->isMethod(Request::METHOD_POST)
            ? Rule::unique('users')
            : Rule::unique('users')->ignore($this->user);
    }

    /**
     * Get user attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return [
            ...$this->validated(),
            ...['password' => Hash::make($this->password)],
        ];
    }
}
