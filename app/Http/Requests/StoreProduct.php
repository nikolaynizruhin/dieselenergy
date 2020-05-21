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
     * Get attribute values.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAttributeValues()
    {
        $attributes = $this->get('attributes', []);

        return collect($attributes)->map(fn ($attribute) => ['value' => $attribute]);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['is_active' => $this->get('is_active', false)]);
    }
}
