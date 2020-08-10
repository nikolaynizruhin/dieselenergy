<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateMedia extends StoreMedia
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'product_id' => [
                'required',
                'numeric',
                'exists:products,id',
                Rule::unique('image_product')
                    ->ignore($this->media)
                    ->where(fn ($query) => $query->where([
                        'image_id' => $this->image_id,
                    ])),
            ],
        ]);
    }
}
