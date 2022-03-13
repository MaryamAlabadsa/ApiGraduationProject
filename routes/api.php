<?php

use App\Http\Requests\AddPostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\NewPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
//    return $request->user();


});


Route::middleware(['auth:sanctum'])->group(function () {
    //post
    Route::post('getPostById', [\App\Http\Controllers\Api\PostsController::class, 'getPostById']);
    Route::get('getAllPosts', [\App\Http\Controllers\Api\PostsController::class, 'getAllPosts']);
    Route::post('deletePost', [\App\Http\Controllers\Api\PostsController::class, 'deletePost']);
    Route::post('getUserProfile', [\App\Http\Controllers\Api\PostsController::class, 'getUserProfile']);
    Route::post('editPost', [\App\Http\Controllers\Api\PostsController::class, 'editPost']);
    Route::post('getPostByCategoray', [\App\Http\Controllers\Api\PostsController::class, 'getPostByCategoray']);
    //log out
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('changePassword', [NewPasswordController::class, 'changePassword']);
    //request
    Route::post('addRequest', [\App\Http\Controllers\RequestsController::class, 'addRequest']);
    Route::post('getAllRequests', [\App\Http\Controllers\RequestsController::class, 'getAllRequests']);
    Route::post('deleteRequest', [\App\Http\Controllers\RequestsController::class, 'deleteRequest']);
    //Category
    Route::post('addCategory', [\App\Http\Controllers\CategoryController::class, 'addCategory']);
    Route::post('editCategory', [\App\Http\Controllers\CategoryController::class, 'editCategory']);
    Route::post('getAllCategories', [\App\Http\Controllers\CategoryController::class, 'getAllCategories']);

    Route::post('addPost',  [\App\Http\Controllers\Api\PostsController::class, 'addPost']);
});




Route::get('getAllMedias', [\App\Http\Controllers\MediaController::class, 'getAllMedias']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('deleteAllUsers', [AuthController::class, 'm']);

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::post('forgotPassword', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);
Route::post('img', function (){
    dd();
});


//
