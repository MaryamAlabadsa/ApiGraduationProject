<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPostRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
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
//        dd(Post::all());
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
            'data' => PostResource::make($post),
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
        } else{
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
        return ['message' => 'You have successfully delete your order.',
        ];
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
}
