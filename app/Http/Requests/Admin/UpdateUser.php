<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateUser extends StoreUser
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        unset($rules['password']);

        return [
            ...$rules,
            ...[
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($this->user),
                ],
            ],
        ];
    }
}
