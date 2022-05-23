<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($request->all());

        return [
            'id' => $this->id,
            'massage' => $this->massage,
            'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'user_image' => $this->user_image_link,
            'created_at' => $this->created_at,
            'user_phone_number' => $this->user?$this->user->phone_number:"0",
            'published_at' => $this->created_at->diffForHumans(now()),

        ];
    }
}
