<?php

namespace App\Http\Requests\PageCategory;

use Illuminate\Foundation\Http\FormRequest;

class CreatePageCategoryRequest extends FormRequest
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
            'page_id' => 'required|regex:/^[0-9]+$/',
            'category_id' => 'required|regex:/^[0-9]+$/',
            'display_name' => 'required|string'
        ];
    }
}
