<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('control_panel.post.post');
//});
Route::get('/',[\App\Http\Controllers\PostController::class,'index']);

//user
Route::get('users', function () {
    return view('control_panel.user.users');
});
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

