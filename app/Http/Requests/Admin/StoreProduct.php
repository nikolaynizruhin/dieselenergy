<?php

namespace App\Http\Requests\Admin;

use App\Models\Specification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

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
            'model' => 'required|string|max:255|unique:products',
            'slug' => 'required|string|alpha_dash|max:255|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'is_active' => 'boolean',
            'brand_id' => 'required|numeric|exists:brands,id',
            'category_id' => 'required|numeric|exists:categories,id',
            'images.*' => 'image',
        ] + $this->getAttributeRules('nullable|string|max:255');
    }

    /**
     * Get attribute values.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAttributeValues()
    {
        $attributes = Arr::get($this->validated(), 'attributes', []);

        return collect($attributes)->map(fn ($attribute) => ['value' => $attribute]);
    }

    /**
     * Get validated product attributes.
     *
     * @return array
     */
    public function getProductAttributes()
    {
        return Arr::except($this->validated(), 'attributes');
    }

    /**
     * Get images.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getImages()
    {
        return collect($this->file('images'))->map(fn ($image) => [
            'path' => $image->store('images'),
        ]);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }

    /**
     * Get attributes rules.
     *
     * @param  string|array  $rules
     * @return array
     */
    protected function getAttributeRules($rules)
    {
        return Specification::getValidationRules($this->category_id, $rules);
    }
}
