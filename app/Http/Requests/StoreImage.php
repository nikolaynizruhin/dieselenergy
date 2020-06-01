<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImage extends FormRequest
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
            'images.*' => 'required|image',
        ];
    }

    /**
     * Get images.
     *
     * @return array
     */
    public function getImages()
    {
        return collect($this->file('images'))->map(fn ($image) => [
            'path' => $image->store('images'),
            'created_at' => now(),
            'updated_at' => now(),
        ])->all();
    }
}
