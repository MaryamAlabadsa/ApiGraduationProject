<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $token = $this->user()->createToken('authtoken');

        return
            [
                'message' => 'Logged in baby',
                'data' => [
                    'user' => $request->user(),
                    'token' => $token->plainTextToken
                ]
            ];
    }
}
