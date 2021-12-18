<?php

namespace App\Http\Requests\Admin;

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

    /**
     * Get prepared data.
     *
     * @return array
     */
    public function prepared()
    {
        return [
            ...$this->validated(),
            ...['total' => intval($this->total * 100)],
        ];
    }
}
