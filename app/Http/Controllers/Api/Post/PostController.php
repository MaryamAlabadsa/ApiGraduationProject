<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPostRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Sodium\add;

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
            'data' => [PostResource::make($post)],
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
            'data' => PostResource::make($post),
//            'orders'=> $post->post_orders!=null ?OrderResource::make($post->post_orders):null
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
        if (!$post->second_user) {
            if ($post->first_user === $user->getAuthIdentifier()) {
                if ($post->first_user !== $request->second_user) {
                    $post->fill($request->only(['second_user']));
                    $post->save();
                    $post_owner_name = $post->first_user_name;
                    $token = $post->second_user_token;
                    if (!$token)
                        sendnotification($token, "new request", $post_owner_name . "  accept your request",$post->id);
                    Notification::create([
                        'post_id' => $post->id,
                        'sender_id' => Auth::id(),
                        'receiver_id' => $post->second_user_token,
                        'type' => 'accept_request',
                    ]);

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

    public function getPostByCategory(Request $request)
    {
        $post = Post::where('category_id', $request->category_id)->get();
        return new PostCollection($post);
    }

    public function getPostDividedByIsDonation(Request $request)
    {
        $post = Post::where('is_donation', $request->is_donation)->get();
        return new PostCollection($post);
    }

    public function getPostOrders(Request $request)
    {
//        $post = Post::with('order')->where([
//            ['id', '=', $id] , ['first_user', '=', $userId]
//        ]);
////        dd($post);
//        if ($post != null)
//            return response()->json($post);
////            return new PostCollection($post);
//        else
//            return response()->json("null");
//        $posts = Post::with('orders')->where('id', $id)
//            ->where('first_user', $userId)
//            ->findOrFail();

        $posts = Post::where('id', $request->post_id)->first();
//        getPostMediaAttribute
//        dd($posts->post_media);
        return response()->json(
            [
                $posts->post_orders,
                new PostResource($posts)
            ]
        );

    }
}
