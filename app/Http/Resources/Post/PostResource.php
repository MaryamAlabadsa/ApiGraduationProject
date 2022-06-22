<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Order\OrderResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'is_donation' => $this->is_donation,
            'category_id' => $this->category_id,
            'first_user_id' => $this->first_user,
            'second_user_id' => $this->second_user_data?$this->second_user_data->id:0,
            'category_name' => $this->category_name,
            'number_of_requests' => $this->number_of_requests,
            'first_user_name' => $this->first_user_name,
            'second_user_name' => $this->second_user_name,
            'post_first_user_email' => $this->post_first_user_email,
            'post_second_user_email' => $this->post_second_user_email,
            'post_media' => $this->post_media,
            'first_user_image_link' => $this->first_user_image_link,
            'is_ordered' => $this->is_ordered != false ? true : false,
            'Order_id' => $this->is_ordered == true ? $this->is_ordered->id: 0,
            'is_he_the_owner_of_the_post' => $this->first_user===Auth::id()?true:false,
            'is_completed' => $this->second_user===null?false:true,
            'published_at' => $this->created_at->diffForHumans(now()),
            'the_owner_is_login' => $this->first_user==Auth::id()?true:false,
        ];
    }
}
