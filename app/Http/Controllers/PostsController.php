<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function addPost(Request $request)
    {
        $request->validate([
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
//            //  'img' => 'required|text',
//            'phone_number' => 'required|numeric|min:10',
//            'address' => 'required|string|max:255',
//            'Longitude' => 'string|max:255',
//            'Latitude' => 'string|max:255',
//            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_donation' => $request->is_donation,
            'category_id' => $request->category_id,
            // 'number_of_requests' => $request->number_of_requests,
            'first_user' => Auth::user()->getAuthIdentifier(),
//            'donor_id' => $request->donor_id,
//            'beneficiary_id' => $request->beneficiary_id,
        ]);

        return response()->json(
            [
                'message' => 'added Successfully',
                'data' => ['post' => $post]
            ]
        );

    }


    public function getAllPosts()
    {
        $post = Post::all();
        return response()->json(
            [
                'message' => 'done',
                'data' => [
                    'posts' => $post
                ]
            ]
        );
    }

    public function getPostById(Request $request)
    {
        $post = Post::where('id', $request->id)->first();
        return response()->json(
            [
                'message' => 'Logged in baby',
                'data' => [
                    'posts' => $post
                ]
            ]
        );
    }

    public function getPostByCategoray(Request $request)
    {
        $post = Post::where('category_id', $request->category_id)->get();
        return response()->json(
            [
                'message' => 'done',
                'data' => [
                    'posts' => $post
                ]
            ]
        );
    }

    function deletePost(Request $request)
    {
        $post = Post::where('id', $request->id)->first();
        $post->delete();
        return response()->json(
            [
                'message' => 'Deleted Successfully ',
            ]
        );
    }

    public
    function getUserProfile(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $donationPost = Post::where('first_user', $request->id)->get();
        $beneficiaryPost = Post::where('second_user', $request->id)->get();
        $re = \App\Models\Request::where('user_id', $request->id)->get();
        return response()->json(
            [
                'message' => 'Successfully',
                'data' => [
                    'user' => $user,
                    'donationPost' => $donationPost,
                    'beneficiaryPost' => $beneficiaryPost,
                    'Requests' => $re
                ]
            ]
        );
    }

    public
    function editPost(Request $request)
    {
        $post = Post::where('id', $request->id)->first();
        $post->title = request('title');
        $post->description = request('description');
        $post->is_donation = request('is_donation');
        $post->category_id = request('category_id');
        $post->is_donation = request('is_donation');
//        $post->donor_id = request('donor_id');
//        $post->beneficiary_id = request('beneficiary_id');
        $post->second_user = request('second_user');

        $post->update();

        return response()->json(
            [
                'message' => 'updated Successfully',
                'data' => [
                    'post' => $post
                ]
            ]
        );
    }

    public
    function postsIsAvilable(Request $request)
    {

    }


}
