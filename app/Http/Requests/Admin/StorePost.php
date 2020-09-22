<?php

namespace App\Http\Requests\Admin;

use App\Models\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

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
            'title' => 'required|string|max:255|unique:posts',
            'slug' => 'required|string|alpha_dash|max:255|unique:posts',
            'excerpt' => 'required|string',
            'body' => 'required|string',
            'image' => 'required|image',
        ];
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
        return Arr::except($this->validated(), 'image') + [
            'image_id' => $this->createImage()->id,
        ];
    }
}
