<?php

namespace App\Http\Requests\Admin;

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
                Rule::unique('attribute_category')
                    ->ignore($this->specification)
                    ->where(fn ($query) => $query->where([
                        'category_id' => $this->category_id,
                    ])),
            ],
        ]);
    }
}
