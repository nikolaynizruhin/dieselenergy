<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
            'name' => 'required|string|max:255|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'is_active' => 'boolean',
            'brand_id' => 'required|numeric|exists:brands,id',
            'category_id' => 'required|numeric|exists:categories,id',
        ];
    }

    /**
     * Get prepared data.
     *
     * @return array
     */
    public function prepared()
    {
        $validatedData = $this->validated();

        if (! $this->has('is_active')) {
            $validatedData['is_active'] = false;
        }

        return $validatedData;
    }
}
