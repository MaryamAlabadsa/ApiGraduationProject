<?php
use App\Http\Controllers\ControlPanel\PostController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    dd("ASDASD");
    return "Cache is cleared";
});
Route::get('/', function () {
    $posts = Post::all();
    return view('control_panel.post.all_post',['posts'=>$posts]);
});
Route::get('/posts/{id}',[\App\Http\Controllers\PostController::class,'show']);
Route::resource('users', \App\Http\Controllers\control_panel\UserController::class);

//Route::get('/',[\App\Http\Controllers\PostController::class,'index']);

//user
//Route::get('users',[\App\Http\Controllers\PostController::class]);
Route::get('create_user', function () {
    return view('control_panel.user.create_user');
});
Route::get('login', function () {
    return view('control_panel.user.login');
});
Route::get('register', function () {
    return view('control_panel.user.register');
});
//profile
Route::get('profile', function () {
    return view('control_panel.user.profile');
});

Route::get('post', function () {
    return view('control_panel.post.post');
});

