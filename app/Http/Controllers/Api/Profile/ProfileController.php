<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\Order\OrderCollection;
use App\Http\Resources\User\UserResource;
use App\Models\Order;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getMyDonationPosts()
    {
        $userId = Auth::id();
        return response()->json(
            [
                'message' => 'returned successfully',
                'data' => [
                    'postsList' => $this->DonationPosts($userId)
                ]
            ]
        );
    }

    public function getMyRequestPosts()
    {
        $userId = Auth::id();
        return response()->json(
            [
                'message' => 'returned successfully',
                'data' => [
                    'postsList' => $this->RequestPosts($userId)
                ]
            ]
        );
    }

    public function getUserDonationPosts($userId)
    {
        return response()->json(
            [
                'message' => 'returned successfully',
                'data' => [
                    'postsList' => $this->DonationPosts($userId)
                ]
            ]
        );
    }

    public function getUserRequestPosts($userId)
    {
        return response()->json(
            [
                'message' => 'returned successfully',
                'data' => [
                    'postsList' => $this->RequestPosts($userId)
                ]
            ]
        );
    }

    public function getUserProfileInfo($userId)
    {
        $user = User::where('id', $userId)->first();
        $user_image = $user->img ? url('/storage/' . $user->img) : url("control_panel_style/images/faces/face1.jpg");

        return response()->json(
            [
                'message' => 'returned successfully',
                'data' => [
                   'user'=> UserResource::make($user),
                    'num_donation_post' => count($this->DonationPosts($userId)),
                    'num_request_post' => count($this->RequestPosts($userId)),
                ]
            ]
        );
    }

    public function getMyProfileInfo()
    {
        $userId = Auth::id();

        $user = User::where('id', $userId)->first();
        $user_image = $user->img ? url('/storage/' . $user->img) : url("control_panel_style/images/faces/face1.jpg");

        return response()->json(
            [
                'message' => 'returned successfully',
                'data' => [
                    'user_image' => $user_image,
                    User::select('name')->where('id', $userId)->first(),
                    'num_donation_post' => count($this->DonationPosts($userId)),
                    'num_request_post' => count($this->RequestPosts($userId)),
                ]
            ]
        );
    }

    public function RequestPosts($userId)
    {
        $posts = Post::where([['is_donation', '=', 1], ['first_user', '=', $userId]
        ])->get();
        $orders = Order::whereIn('post_id', Post::select('id')->where([['is_donation', '=', 0]
            , ['first_user', '=', $userId]
        ])->get())->get();
        $all_data = $orders->merge($posts);
        $all_sorted_data = $all_data->sortByDesc('created_at');
        $data = array();
        foreach ($all_sorted_data as $all_sorted_datum) {
            array_push($data, $all_sorted_datum->get_data);
        }
        return $data;
    }

    public function DonationPosts($userId)
    {
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
        return $data;
    }


}