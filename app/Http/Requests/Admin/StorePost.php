<?php

namespace App\Http\Requests\Admin;

use App\Models\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class StorePost extends FormRequest
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
            'title' => [
                'required',
                'string',
                'max:255',
                $this->unique('post'),
            ],
            'slug' => [
                'required',
                'string',
                'alpha_dash',
                'max:255',
                $this->unique('post'),
            ],
            'image' => $this->isMethod(Request::METHOD_POST)
                ? 'required|image'
                : 'image',
            'excerpt' => 'required|string',
            'body' => 'required|string',
        ];
    }

    /**
     * Create an image.
     */
    public function createImage(): Image
    {
        return Image::create([
            'path' => $this->file('image')->store('images'),
        ]);
    }

    /**
     * Get validated product attributes.
     */
    public function getAttributes(): array
    {
        $attributes = Arr::except($this->validated(), 'image');

        if ($this->hasFile('image')) {
            $attributes['image_id'] = $this->createImage()->id;
        }

        return $attributes;
    }
}
