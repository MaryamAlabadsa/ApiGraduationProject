<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Post extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (String)$this->id,
            'title' => $this->title,
            'description' => $this->description,
            'is_donation' => $this->is_donation,
            'number_of_requests' => $this->number_of_requests,
            'post_first_user' => $this->post_first_user,
            'post_second_user' => $this->post_second_user,
            //'post_first_user_email' => $this->post_first_user_email,
            //'post_second_user_email' => $this->post_second_user_email,
        ];
    }
}
