<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostRequest extends FormRequest
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
//            'title' => 'required|string',
//            'description' => 'required|string',
//            'is_donation' => 'required|numeric|in:0,1',
//            'category_id' => 'required|numeric|exists:categories,id',

        ];
    }
    public function messages()
    {
        return [
            'category_id.exists:categories,id' => 'this category_id dose not exist',
            'id.exists:posts,id' => 'this id dose not exist',
            'first_user.equal(Auth::id())' => 'this id not exist',

        ];
    }
}
