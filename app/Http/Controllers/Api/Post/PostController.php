<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPostRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PostCollection
     */
    public function index()
    {
        return new PostCollection(Post::all());
//        return Post::all()->is_ordered;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function store(AddPostRequest $request)
    {

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'is_donation' => $request->is_donation,
            'first_user' => Auth::id(),
        ]);

        if ($request->hasFile('assets')) {
            foreach ($request->assets as $file) {
                $image_name = $file->store('public', 'public');
                $post->media()->create([
                    'post_id' => $post->id,
                    'name' => $image_name,
                ]);
            }
        }
        return ['message' => 'added Successfully',
            'data' => PostResource::make($post),
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return array
     */
    public function show(Post $post)
    {
        return ['message' => 'Successfully',
//            'data' => PostResource::make($post),
//            'data' => $post->post_orders,
            'data' => $post->is_ordered,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return array
     */
    public function update(Request $request, Post $post)
    {
        $user = auth('sanctum')->user();
//        dd($request->second_user);
        if (!$post->second_user) {
            if ($post->first_user === $user->getAuthIdentifier()) {
                if ($post->first_user !== $request->second_user) {
                    $post->fill($request->only(['second_user']));
                    $post->save();
                    return ['message' => 'updated Successfully',
                        'data' => PostResource::make($post),
                    ];
                }
            } else {
                return ['message' => 'your not the owner of this post ',
                    'data' => null,
                ];
            }
        } else {
            return ['message' => 'this item has been taken',
                'data' => null,
            ];
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return array
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return ['message' => 'You have successfully delete your post.',
        ];
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

    public function getPostOrders($id)
    {
        $userId = Auth::id();
//        $post = Post::with('order')->where([
//            ['id', '=', $id] , ['first_user', '=', $userId]
//        ]);
////        dd($post);
//        if ($post != null)
//            return response()->json($post);
////            return new PostCollection($post);
//        else
//            return response()->json("null");
        $posts = Post::with('order')->where('id', $id)->where('first_user', $userId);
        $postOrders = $posts->get();

        return response()->json(
            [
                $postOrders
            ]
        );

    }
}
