<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdatePost extends StorePost
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ...parent::rules(),
            ...[
                'title' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('posts')->ignore($this->post),
                ],
                'slug' => [
                    'required',
                    'string',
                    'alpha_dash',
                    'max:255',
                    Rule::unique('posts')->ignore($this->post),
                ],
                'image' => 'image',
            ],
        ];
    }

    /**
     * Get validated product attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        $attributes = Arr::except($this->validated(), 'image');

        if ($this->hasFile('image')) {
            $attributes['image_id'] = $this->createImage()->id;
        }

        return $attributes;
    }
}
