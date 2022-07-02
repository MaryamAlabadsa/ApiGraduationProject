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

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('posts',\control_panel\PostController::class);
Route::get('/getPostsData', [\App\Http\Controllers\control_panel\PostController::class,'getData'])->name('posts.getData');
Route::get('/postsOrders/{id}', [\App\Http\Controllers\control_panel\PostController::class,'ShowOrders'])->name('posts.ShowOrders');
Route::get('/postsImages/{id}', [\App\Http\Controllers\control_panel\PostController::class,'showImages'])->name('posts.showImages');
Route::get('/profileCard/{id}', [\App\Http\Controllers\control_panel\UsersController::class,'showUserProfileCard'])->name('posts.ShowProfileCard');

Route::resource('users',\control_panel\UsersController::class);
Route::get('/getUsersData', [\App\Http\Controllers\control_panel\UsersController::class,'getData'])->name('users.getData');


Route::get('/profile/{user}', [\App\Http\Controllers\control_panel\ProfileController::class,'index']);
Route::get('/getProfileUsersData', [\App\Http\Controllers\control_panel\ProfileController::class,'getData'])->name('profile.getData');


