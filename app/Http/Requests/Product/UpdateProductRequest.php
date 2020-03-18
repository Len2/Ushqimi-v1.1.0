<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required|string',
            'price' => 'required|regex:/^\-?[0-9]+(?:\.[0-9]+)?$/',
            'category_id' => 'required|regex:/^[0-9,-]*$/',
            'page_id' => 'required|regex:/^[0-9]+$/',
            'image' => 'image',
        ];
    }
}