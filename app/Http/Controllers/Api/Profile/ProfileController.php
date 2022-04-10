<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\Order\OrderCollection;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getDonationPosts()
    {
        $userId = Auth::id();
        $posts = Post::where([['is_donation', '=', 0]
            , ['first_user', '=', $userId]
        ])->get();
        $orders = Order::whereIn('post_id', Post::select('id')->where([['is_donation', '=', 1]
            , ['first_user', '=', $userId]
        ])->get())->get();
//        dd($orders);
        $all_data = $orders->merge($posts);
        $all_sorted_data = $all_data->sortByDesc('created_at');
        $data = array();
        foreach ($all_sorted_data as $all_sorted_datum) {
            array_push($data, $all_sorted_datum->get_data);
        }
//        dd($data);
        return response()->json(
            [
                'message' => 'returned successfully',
                'data' => [
                    'donations posts' => $data
//                    'donations posts' => $all_data
                ]
            ]
        );
    }


    public function getRequestPosts()
    {
        $posts = Post::where('is_donation', 1)->get();
//        dd($posts);
        $orders = Order::whereIn('post_id', Post::select('id')->where('is_donation', 0)->get())->get();
//        dd($orders);
        $all_data = $orders->merge($posts);
//        dd($all_data);
        $all_sorted_data = $all_data->sortByDesc('created_at');
//        dd($all_sorted_data);
        $data = array();
        foreach ($all_sorted_data as $all_sorted_datum) {
            array_push($data, $all_sorted_datum->get_data);
        }
//        dd($data);
        return response()->json(
            [
                'message' => 'returned successfully',
                'data' => [
                    'Requests posts' => $data
//                    'donations posts' => $all_data
                ]
            ]
        );
    }

}
