<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'Longitude' => $this->Longitude,
            'Latitude' => $this->Latitude,
            'phone_number' => $this->phone_number,
            'email_verified_at' => $this->email_verified_at,
            'image_link' => $this->image_link,

        ];
    }
}
