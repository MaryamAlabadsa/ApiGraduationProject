<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        setLang($this->lang);

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
            'title' => 'required|string',
            'description' => 'sometimes|required|string',
            'is_donation' => 'required|numeric|in:0,1',
            'assets' => 'required|array',
            'assets.*' => 'required|mimes:jpg,png,jpeg',
            'category_id' => 'required|numeric|exists:categories,id',

        ];
    }

    public function messages()
    {
        return [
            'category_id.exists:categories,id' => 'category_id is not exist',
            'id.exists:categories,id' => 'this id not exist',
        ];
    }
}
