<?php

use App\Http\Controllers\Api\auth\AuthController;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmailVerificationController;


Route::middleware('auth:sanctum', 'verified')->get('/user', function (Request $request) {
    //    return $request->user();


});


Route::middleware(['auth:sanctum'])->group(function () {
    //post
    Route::apiResource('post', \Api\Post\PostController::class);

    Route::apiResource('order', \Api\Order\OrderController::class);
    Route::apiResource('Category', \Api\Category\CategoryController::class);

    Route::post('PostOrders', [\App\Http\Controllers\Api\Order\OrderController::class, 'getPostOrders']);
    Route::post('PostByCategory/{id}', [\App\Http\Controllers\Api\Post\PostController::class, 'getPostByCategory']);
    Route::post('PostDividedByIsDonation/{id}', [\App\Http\Controllers\Api\Post\PostController::class, 'getPostDividedByIsDonation']);
    Route::post('/restorePost/{id}', [\App\Http\Controllers\Api\Post\PostController::class, 'restorePost']);
    Route::post('/restoreOrder/{id}', [\App\Http\Controllers\Api\Order\OrderController::class, 'restoreOrder']);
    Route::post('/searchPost', [\App\Http\Controllers\Api\Post\PostController::class, 'scopeSearchPostData']);
    Route::put('/changePostStatus/{post}', [\App\Http\Controllers\Api\Post\PostController::class, 'changePostStatus']);
    Route::post('/editPost/{post}', [\App\Http\Controllers\Api\Post\PostController::class, 'updatePost']);

    Route::post('myDonationPosts', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'getMyDonationPosts']);
    Route::post('myRequestsPosts', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'getMyRequestPosts']);
    Route::post('UserDonationPosts/{id}', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'getUserDonationPosts']);
    Route::post('UserRequestPosts/{id}', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'getUserRequestPosts']);
    Route::post('UpdateUserData', [AuthController::class, 'updateUserData']);

    Route::delete('deleteImage', [\App\Http\Controllers\Api\Media\MediaController::class, 'deleteImage']);




    Route::post('myProfileInfo', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'getMyProfileInfo']);
    Route::post('userProfileInfo/{id}', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'getUserProfileInfo']);

    //log out
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('changePassword', [\App\Http\Controllers\Api\auth\NewPasswordController::class,'changePassword']);//[NewPasswordController::class, 'changePassword']);
    Route::post('updateUserImage', [AuthController::class, 'updateUserImage']);
    Route::get("sendDeviceToken/{token}", function ($token) {
        Illuminate\Support\Facades\Auth::user()->update(['fcm_token'=>$token]);
        return ['message' => 'updated Successfully'];
    });
    Route::get('notification', [\App\Http\Controllers\NotificationController::class, 'index']);


});

Route::post('storeNotification', [\App\Http\Controllers\NotificationController::class, 'store']);


Route::get('getAllMedias', [\App\Http\Controllers\Api\Media\MediaController::class, 'getAllMedias']);

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::post('forgotPassword', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);









//
