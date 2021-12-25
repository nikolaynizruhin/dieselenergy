<?php

namespace App\Http\Requests\Admin;

use App\Models\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class StorePost extends FormRequest
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
            'title' => [
                'required',
                'string',
                'max:255',
                $this->unique(),
            ],
            'slug' => [
                'required',
                'string',
                'alpha_dash',
                'max:255',
                $this->unique(),
            ],
            'image' => 'image'.($this->isMethod(Request::METHOD_POST) ? '|required' : ''),
            'excerpt' => 'required|string',
            'body' => 'required|string',
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
            ? Rule::unique('posts')
            : Rule::unique('posts')->ignore($this->post);
    }

    /**
     * Create an image.
     *
     * @return \App\Models\Image
     */
    public function createImage()
    {
        return Image::create([
            'path' => $this->file('image')->store('images'),
        ]);
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
