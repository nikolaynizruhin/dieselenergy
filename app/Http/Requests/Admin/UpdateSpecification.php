<?php

namespace App\Http\Requests\Admin;

use App\Category;
use Illuminate\Validation\Rule;

class UpdateSpecification extends StoreSpecification
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'attribute_id' => [
                'required',
                'numeric',
                'exists:attributes,id',
                Rule::unique('attributables')
                    ->ignore($this->specification)
                    ->where(fn ($query) => $query->where([
                        'attributable_id' => $this->category_id,
                        'attributable_type' => Category::class,
                    ])),
            ],
        ]);
    }
}
