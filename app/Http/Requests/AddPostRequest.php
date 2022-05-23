<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPostRequest extends FormRequest
{
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
            'title' => 'required|string',
            'description' => 'sometimes|required|string',
            'is_donation' => 'required|numeric|in:0,1',
 //            'assets' => 'required|array',
//            'assets.*' => 'required|mimes:jpg,png,jpeg',
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
