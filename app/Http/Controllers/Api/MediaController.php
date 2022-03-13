<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function getAllMedias()
    {

        $media = Media::all();
        return response()->json(
            [
                'message' => 'done',
                'data' => [
                    'media' => $media
                ]
            ]
        );
    }
}
