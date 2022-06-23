<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
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
    public function index(Request $request)
    {
        if (!isset($request->limit) || empty($request->limit)) {
            $request->limit = 10;
        }

        $posts = Post::orderBy('created_at', "desc")->paginate($request->limit);

        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function store(StorePostRequest $request)
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
        sendnotification(adminToken()
            , "some one add new post", Auth::user()->name . "add new post ", ['post_id' => $post->id]);
        Notification::create([
            'post_id' => $post->id,
            'sender_id' => Auth::id(),
            'receiver_id' => adminId(),
            'type' => 'admin',
        ]);
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
        $order = Order::where('post_id', $post->id)->get();
        return ['message' => 'Successfully',

            'post' => PostResource::make($post),
            'orders' => OrderResource::collection($order)

        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return string[]
     */
    public function update(Request $request, Post $post)
    {
//        dd($request->title);
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'is_donation' => $request->is_donation,
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
        return ['message' => 'You have successfully delete your order.'];

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return array
     */
    public function changePostStatus(Request $request, Post $post)
    {

//        dd($post->id);
        $user = auth('sanctum')->user();
        if (!$post->second_user) {
            if ($post->first_user === $user->getAuthIdentifier()) {
                if ($post->first_user !== $request->second_user) {
                    $post->fill($request->only(['second_user']));
                    $post->save();
                    $post_owner_name = $post->first_user_name;
                    $token = $post->second_user_token;
//                    if ($token)
                    sendnotification($token, "accept request", $post_owner_name . "  accept your request", ['post_id' => $post->id]);
                    sendnotification(adminToken()
                        , "some one accept order", Auth::user()->name . "accept order ", ['post_id' => $post->id]);
                    Notification::create([
                        'post_id' => $post->id,
                        'sender_id' => Auth::id(),
                        'receiver_id' => $post->second_user_token,
                        'type' => 'accept_request',
                    ]);
                    Notification::create([
                        'post_id' => $post->id,
                        'sender_id' => Auth::id(),
                        'receiver_id' => adminId(),
                        'type' => 'admin',
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
        $user = Auth::id();
        if ($post->user_id == $user) {
            $post->delete();
            return ['message' => 'You have successfully delete your post.'];
        } else
            return ['message' => 'You can not delete this post.'];
    }

    public function restorePost($id)
    {
        $deletePost = Post::onlyTrashed()->where([["deleted_at", '!=', null], ['id', '=', $id]])->first();
        if ($deletePost) {
            $deletePost->restore();
            return ['message' => 'You have successfully restore your post.'];

        }
        return ['message' => 'You can not restore this order.'];

    }


    public function getPostByCategory($id, Request $request)
    {
        if (!isset($request->limit) || empty($request->limit)) {
            $request->limit = 10;
        }
        $post = Post::postcategory($request->category_id)->donation($id)->status($request->postStatus)
            ->orderBy('created_at', "desc")->paginate($request->limit);
        return new PostCollection($post);
    }

    public function getPostDividedByIsDonation($id, Request $request)
    {
        if (!isset($request->limit) || empty($request->limit)) {
            $request->limit = 10;
        }
        $post = Post::donation($id)->status($request->postStatus)->orderBy('created_at', "desc")->paginate($request->limit);

        return new PostCollection($post);
    }

    public function getPostOrders(Request $request)
    {
        $posts = Post::where('id', $request->post_id)->first();

        return response()->json(
            [
                $posts->post_orders,
                new PostResource($posts)
            ]
        );

    }

    public function scopeSearchPostData(Request $request)
    {
        if (!isset($request->limit) || empty($request->limit)) {
            $request->limit = 10;
        }
        $post = Post::donation($request->is_donation)->status($request->status)->postcategory($request->category)->data($request->data)->orderBy('created_at', "desc")->paginate($request->limit);
        return new PostCollection($post);

    }
}
