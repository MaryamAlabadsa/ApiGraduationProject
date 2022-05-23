<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
//        dd('kkk');
         return
        [
            'message' => 'done',
            'data'=>CategoryResource::collection(Category::all()),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        $category = Category::create([
            'name' => $request->name,
            'image' => $request->image->store('public', 'public'),
        ]);

        return response()->json(
            [
                'message' => 'added Successfully',
                'data' => CategoryResource::make($category),
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return array
     */
    public function show(Category $category)
    {
        return ['message' => 'Successfully',
            'data' => CategoryResource::make($category),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
