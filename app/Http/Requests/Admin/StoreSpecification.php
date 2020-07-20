<?php

namespace App\Http\Requests\Admin;

use App\Category;
use Illuminate\Foundation\Http\FormRequest;
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
                Rule::unique('attributables')->where(fn ($query) => $query->where([
                    'attributable_id' => $this->category_id,
                    'attributable_type' => Category::class,
                ])),
            ],
            'is_featured' => 'boolean',
        ];
    }
}
