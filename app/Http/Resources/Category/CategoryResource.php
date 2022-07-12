<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($request->all());
        return [
            'id' => $this->id,
            'name' =>$request->lang?($request->lang=='ar'?$this->name_ar:$this->name): ucfirst($this->name),
//            'name_ar' => ucfirst($this->name_ar),
            'image' => $this->image_link,
        ];
    }
}
