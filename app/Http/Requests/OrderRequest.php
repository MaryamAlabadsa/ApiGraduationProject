<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderRequest extends FormRequest
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
            'massage' => 'required|string',
            'post_id' => 'required|numeric|exists:posts,id',

        ];
    }
    public function messages()
    {
        return [

            'post_id.exists:posts,id' => 'post_id is not exist',
//            'user_id.exists:users,id' => 'this user id not exist',

        ];
    }
}
