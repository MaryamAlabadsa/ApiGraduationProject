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
//        $ma = Order::all()->load('post');
//        dd($ma);
//        $user = Auth::id();
//
////        dd($user);
        $posts = Post::where('is_donation', 0)->get();
//        return new OrderCollection($ma);
//        return Order::all();
        $orders = Order::whereHas('post', function ($quary) {
            $quary->where('is_donation', 1);
        })->get();
//
////        foreach ($posts->$p){
////            if ($p->first_user === $user->getAuthIdentifier()) {
//                $all_data = $orders->merge($posts);
////            }
////            }
////        if ($posts->first_user === $user &&$orders->user_id === $user) {
//            $all_data = ($orders->toArray())->merge($posts->toArray());
        dd(array_merge($orders->toArray(),$posts->toArray()));

//        $all_data = array_merge();
//        dd($orders->toArray(), $posts->toArray());

//            $all_sorted_data = $all_data->sortByDesc('created_at');
//            return response()->json(
//                [
//                    'message' => 'returned successfully',
//                    'data' => [
////                        'donations posts' => $all_sorted_data
//                        'donations posts' => $all_data
//                    ]
//                ]
//            );
////        }
//
//
////        return response()->json(
////            [
////                'message' => 'returned successfully',
////                'data' => [
////                    'donations posts' => "0"
////                ]
////            ]
////        );

    }


    public function getRequstedPosts(PostRequest $request)
    {
        $posts = Post::where('is_donation', 1)->get();
        $orders = Order::where('is_donation', 1)->get();
        $all_data = $orders->merge($posts);
        $all_sorted_data = $all_data->sortByDesc('created_at');
        return response()->json(
            [
                'message' => 'Logged in baby',
                'data' => [
                    'donations posts' => $all_sorted_data
                ]
            ]
        );
    }

}
