<?php

namespace App\Http\Requests\Admin;

use App\Models\Specification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class StoreProduct extends FormRequest
{
    use HasUniqueRule;

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
            'name' => [
                'required',
                'string',
                'max:255',
                $this->unique('product'),
            ],
            'model' => [
                'required',
                'string',
                'max:255',
                $this->unique('product'),
            ],
            'slug' => [
                'required',
                'string',
                'alpha_dash',
                'max:255',
                $this->unique('product'),
            ],
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
     */
    public function getAttributeValues(): Collection
    {
        $attributes = Arr::get($this->validated(), 'attributes', []);

        return collect($attributes)
            ->filter()
            ->map(fn ($attribute) => ['value' => $attribute]);
    }

    /**
     * Get validated product attributes.
     */
    public function getProductAttributes(): array
    {
        return Arr::except(
            [
                ...$this->validated(),
                ...['price' => intval($this->price * 100)],
            ],
            'attributes',
        );
    }

    /**
     * Get images.
     */
    public function getImages(): Collection
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
     */
    protected function getAttributeRules(array|string $rules): array
    {
        return Specification::getValidationRules($this->category_id, $rules);
    }
}
