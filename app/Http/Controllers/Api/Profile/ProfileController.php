<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Order;
use App\Models\Post;

class ProfileController extends Controller
{
    public function getDonationPosts(PostRequest $request)
    {
        $posts = Post::where('is_donation', 1)->get();
        $orders = Order::where('is_Post_donation', 0)->get();
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
