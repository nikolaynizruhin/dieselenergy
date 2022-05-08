<?php

namespace App\Http\Requests\Admin;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

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
        $rules = [
            'customer_id' => 'required|numeric|exists:customers,id',
            'status' => ['required', 'string', new Enum(OrderStatus::class)],
            'notes' => 'nullable|string',
        ];

        if ($this->isMethod(Request::METHOD_PUT)) {
            $rules['total'] = 'required|numeric|min:0';
        }

        return $rules;
    }

    /**
     * Get prepared data.
     *
     * @return array
     */
    public function prepared(): array
    {
        return [
            ...$this->validated(),
            ...['total' => intval($this->total * 100)],
        ];
    }
}
