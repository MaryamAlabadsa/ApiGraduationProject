<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestsController extends Controller
{
    public function getAllRequests(Request $request)
    {
        $re= \App\Models\Request::where('post_id', $request->post_id)->get();
        return response()->json(
            [
                'message' => 'done',
                'data' => [
                    'Requests' => $re
                ]
            ]
        );
    }
    public function addRequest(Request $request)
    {
        $re = \App\Models\Request::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::user()->getAuthIdentifier(),
        ]);
        return response()->json(
            [
                'message' => 'added Successfully',
                'data' => ['post' => $re]
            ]
        );
    }
    function deleteRequest(Request $request)
    {
        $re = \App\Models\Request::where('id', $request->id)->first();
        $re->delete();
        return response()->json(
            [
                'message' => 'Deleted Successfully ',
            ]
        );
    }

}
