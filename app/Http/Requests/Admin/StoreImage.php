<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreImage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'images.*' => 'required|image',
        ];
    }

    /**
     * Get images.
     */
    public function getImages(): array
    {
        return collect($this->file('images'))
            ->map(fn ($image) => [
                'path' => $image->store('images'),
                'created_at' => now(),
                'updated_at' => now(),
            ])->all();
    }
}
