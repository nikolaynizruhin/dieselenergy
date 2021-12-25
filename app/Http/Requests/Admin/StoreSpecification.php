<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreSpecification extends FormRequest
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
            'category_id' => 'required|numeric|exists:categories,id',
            'attribute_id' => [
                'required',
                'numeric',
                'exists:attributes,id',
                $this->unique(),
            ],
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Get unique rule.
     *
     * @return \Illuminate\Validation\Rules\Unique
     */
    private function unique()
    {
        return $this->isMethod(Request::METHOD_POST)
            ? Rule::unique('attribute_category')->where('category_id', $this->category_id)
            : Rule::unique('attribute_category')->ignore($this->specification)->where('category_id', $this->category_id);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['is_featured' => $this->boolean('is_featured')]);
    }
}
