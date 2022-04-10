<?php

use App\Http\Controllers\Api\auth\AuthController;
use App\Http\Requests\AddPostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\NewPasswordController;


Route::middleware('auth:sanctum', 'verified')->get('/user', function (Request $request) {
    //    return $request->user();


});

Route::post('test', [AuthController::class, 'test']);

//Route::get('donationPosts',function (){
//    dd(5);
//});

Route::middleware(['auth:sanctum'])->group(function () {
    //post
    Route::apiResource('post',\Api\Post\PostController::class);

    Route::apiResource('order',\Api\Order\OrderController::class);
    Route::apiResource('Category',\Api\Category\CategoryController::class);

    Route::get('PostOrders/{id}', [\App\Http\Controllers\Api\Post\PostController::class, 'getPostOrders']);

    Route::get('donationPosts', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'getDonationPosts']);
    Route::get('RequestsPosts', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'getRequestPosts']);

//    //log out
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('changePassword', [NewPasswordController::class, 'changePassword']);

});




Route::get('getAllMedias', [\App\Http\Controllers\Api\Media\MediaController::class, 'getAllMedias']);
//Route::post('login',function (){
//    dd("kkk");
//});
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::post('forgotPassword', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);









//
