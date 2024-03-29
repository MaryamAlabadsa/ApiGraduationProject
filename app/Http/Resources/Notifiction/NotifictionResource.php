<?php

namespace App\Http\Resources\Notifiction;

use Illuminate\Http\Resources\Json\JsonResource;

class NotifictionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
//            dd($this->id),
            'id' => $this->id,
            'post_id' => $this->post_id,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'type' => $this->type,
            'sender_name' => $this->sender_name,
            'sent_at' => $this->created_at->diffForHumans(now()),
            'ia_deleted' => $this->deleted_at

//            'published_at' => $this->updated_at->diffForHumans(now()),


        ];
    }
}
