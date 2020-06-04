<?php

namespace App\Http\Requests;

class UpdateOrder extends StoreOrder
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return parent::rules() + ['total' => 'required|numeric|min:0'];
    }
}
