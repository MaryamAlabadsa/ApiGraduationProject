<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public  function index(){
        $posts = Post::all();
//        $posts = DB::table('posts')->paginate(20);
        return view('control_panel.post.post',['posts'=>$posts]);
    }
    public  function show($id){
        $post = Post::where('id',$id)->first();
        return view('post.post',['post'=>$post]);
    }
    public  function create(){
        return view('post.addPost');
    }
    public  function  store(){
//        $post = new Post();
//        $attributes = request()-> validate([
//            'title'=>'required',
//            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'slug'=>['required',Rule::unique('posts','slug')],
//            'excerpt'=>'required',
//            'body'=>'required',
//            'category_id'=>['Required',Rule::exists('category','id')]
//
//        ]);
//        $attributes ['user_id'] = Auth::id();
//        if (isset($attributes['image'])){
//            $attributes['image'] = request()->file('image')->store('images');
//        }
//        $post->save($attributes);
        $post = new Post();
        $post ->user_id =Auth::id();
        $post->title = request('title');
        $post->excerpt = request('excerpt');
        $post->slug = request('slug');
        $post->body = request('body');
        $post->category_id = request('category');
        $post->image = request()->file('image')->store('images');
        $post->save();
        return redirect('/')
            ->with('success','You have successfully add post.');

    }
    function  deletePost($id){
        $post = Post::where('id',$id)->first();
        $post ->delete();
        return redirect('/')
            ->with('success','You have successfully delete post.');
    }
    public  function edit($id){
        $post = Post::where('id',$id)->first();
        return view('post.editPost',['post'=>$post]);
    }

    public  function  editPost($id){
        $post = Post::where('id',$id)->first();
        $post->title = request('title');
        $post->excerpt = request('excerpt');
        $post->slug = request('slug');
        $post->body = request('body');
        $post->category_id = request('category');
//        if (isset($post['image'])){
           $post->image = request()->file('image')->store('images');
//        }
        $post->update();
        return redirect('/')
            ->with('success','You have successfully edit post.');

    }
    public  function  search(){
        $txtSearch = request('search');
        $posts = Post::query()
            ->where('title','Like',"%{$txtSearch}%")
            ->orwhere('slug','Like',"%{$txtSearch}%")
            ->orwhere('body','LIKE',"%{$txtSearch}%")->get();
        return view('post.posts',['posts'=>$posts]);
    }
    public  function showMyPost(){
        $userId = Auth::id();
        $posts = Post::where('user_id',$userId)->get();
//        $user = User::where('id',$userId)->First();
//        $posts = $user->posts;
        return view('post.my-posts',['posts'=>$posts]);
    }
}
