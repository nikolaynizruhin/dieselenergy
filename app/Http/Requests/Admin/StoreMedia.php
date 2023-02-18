<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class StoreMedia extends FormRequest
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
            'is_default' => 'boolean',
            'image_id' => 'required|numeric|exists:images,id',
            'product_id' => [
                'required',
                'numeric',
                'exists:products,id',
                $this->unique(),
            ],
        ];
    }

    /**
     * Get unique rule.
     */
    private function unique(): Unique
    {
        $rule = Rule::unique('image_product')->where('image_id', $this->image_id);

        return $this->isMethod(Request::METHOD_POST) ? $rule : $rule->ignore($this->media);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['is_default' => $this->boolean('is_default')]);
    }
}
