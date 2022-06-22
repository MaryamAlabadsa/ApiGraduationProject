<?php

namespace App\Http\Controllers\control_panel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('post.index', compact('posts'));
    }

    public function getData(Request $request)
    {
//        dd($areas);
        $columns = array(

//            array( 'db' => 'userName',          'dt' => 1 ),
            array('db' => 'title', 'dt' => 2),
            array('db' => 'categoryName', 'dt' => 3),
//            array( 'db' => 'description',   'dt' => 4 )
        );

        $draw = (int)$request->draw;
        $start = (int)$request->start;
        $length = (int)$request->length;
        $order = $request->order[0]["column"];
        $direction = $request->order[0]["dir"];
        $search = trim($request->search["value"]);


        $value = array();

        if (!empty($search)) {
            $count = Post::search($search)
                ->count();
            $items = Post::search($search)
                ->limit($length)->offset($start)->orderBy($columns[$order]["db"], $direction)
                ->get();
        } else {
            $count = Post::count();
            $items = Post::
            limit($length)->offset($start)->orderBy($columns[$order]["db"], $direction)
                ->get();
        }
        foreach ($items as $index => $item) {
//            dd($item->unPaidMaterials);
            array_push($value, $item->Post_display_data);
        }
        return [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => (array)$value,
            "order" => $columns[$order]["db"]
        ];
//        return $areas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $posts = new Post();
        $category = Category::all();
        return response()->json(['view' => view('Post.create', compact('posts', 'category'))->render(), 'Post_id' => $posts->id]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StorePostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePostRequest $request)
    {
        $Post = Post::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
        ]);

        if ($request->hasFile('assets')) {
            $Post->update(['image' => $request->image->store('public', 'public')]);
        }
//        Post::create($request->all());
        return response()->json(['msg' => 'new Post data is created successfully', 'type' => 'success', 'title' => 'Create']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $prodect
     * @return \Illuminate\Http\Response
     */
    public function show(Post $prodect)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $prodect
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Post $Post)
    {
        $categories = Category::all();
        return response()->json(['view' => view('Post.update', compact('Post', 'categories'))->render(), 'Post_id' => $Post->id]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatePostRequest $request
     * @param \App\Models\Post $prodect
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePostRequest $request, Post $Post)
    {
        $Post->name = $request->input('name');
        $Post->description = $request->input('description');
        $Post->category_id = $request->input('category_id');
        $Post->price = $request->input('price');
//        'past_medical_history_id'=>isset($request->past_medical_history_id) ? $request->past_medical_history_id : null,

        $Post->save();
        return response()->json(['msg' => 'a Post data is updated successfully', 'type' => 'success', 'title' => 'Update']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $Post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $Post)
    {
        $Post->delete();
        return response()->json(['msg' => 'a Post data is deleted successfully', 'type' => 'success', 'title' => 'Delete']);

    }

    public function ShowOrders(Request $request)
    {
        $post = Post::where('id', $request->id)->first();
        $orders = Order::where('post_id', $post->id)->get();

        return response()->json(['view' => view('post.showOrders', compact('post', 'orders'))->render(), 'Post_id' => $post->id]);
    }

    public function showImages(Request $request)
    {
        $posts = Post::where('id', $request->id)->first();
//        dd($posts->id);

        return response()->json(['view' => view('post.showPostImages', compact('posts',))->render(), 'Post_id' => $posts->id]);
    }

}
