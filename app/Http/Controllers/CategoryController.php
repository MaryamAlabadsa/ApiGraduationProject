<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAllCategories()
    {

        $category = Category::all();
        return response()->json(
            [
                'message' => 'done',
                'data' => [
                    'category' => $category
                ]
            ]
        );
    }
    public function editCategory(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
        ]);
        $category = Category::where('id', $request->id)->first();
        $category->type = request('type');

        $category->update();

        return response()->json(
            [
                'message' => 'updated Successfully',
                'data' => [
                    'Category' => $category
                ]
            ]
        );
    }
    public function addCategory(Request $request)
    {
        $category = Category::create([
            'type' => $request->type,
        ]);

        return response()->json(
            [
                'message' => 'added Successfully',
                'data' => ['post' => $category]
            ]
        );
    }

}
