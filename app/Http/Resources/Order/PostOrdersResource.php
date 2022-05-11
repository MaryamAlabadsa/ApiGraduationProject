<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class PostOrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'massage' => $this->massage,
            'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            'is_donation_post' => $this->is_donation_post,
            'user_name' => $this->user_name,
            'user_image' => $this->user_image_link,

        ];
    }
}
