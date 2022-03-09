<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPostRequest;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class PostsController extends Controller
{
    public function addPost(AddPostRequest $request)
    {

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_donation' => $request->is_donation,
            'first_user' => Auth::id(),
        ]);
        foreach ($r as $request){
            $image_name =$r->image->store('public','public');
            $post->media()->create([
                'post_id'=>$post->id,
                'name'=>$image_name,
            ]);
        }


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

    public function getPostById(PostRequest $request)
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

    public function getPostByCategoray(PostRequest $request)
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

    function deletePost(PostRequest $request)
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
