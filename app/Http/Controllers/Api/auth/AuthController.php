<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Resources\User\UserResource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            //  'img' => 'required|text',
            'phone_number' => 'required|numeric|min:10',
            'address' => 'required|string|max:255',
            'Longitude' => 'string|max:255',
            'Latitude' => 'string|max:255',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
//            'img' => $i->store('public', 'public'),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'Longitude' => $request->Longitude,
            'Latitude' => $request->Latitude,
            'password' => Hash::make($request->password),

        ]);
        if ($request->image){
            $user->update(['img'=>$request->image->store('public', 'public')]);
        }

        $token = $user->createToken('authtoken');
        sendnotification(adminToken()
            , "new user registered", $user->name ." create new account", ['user_id'=>$user->id]);
        Notification::create([
            'post_id' => 0,
            'sender_id' => $user->id,
            'receiver_id' =>adminId(),
            'type' => 'admin',
        ]);
        return response()->json(
            [
                'message' => 'User Registered',
                'data' => ['token' => $token->plainTextToken,
                    'user' => UserResource::make($user),
                ]
            ]
        );

    }


    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->makeVisible('password');
            if (\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) { // true}else{//false}
                $token = $user->createToken('authtoken');
                return response()->json(
                    [
                        'message' => 'Logged in baby',
                        'data' => [
                            'user' => UserResource::make($user),
                            'token' => $token->plainTextToken
                        ]
                    ]
                );
            } else {
                return response()->json(
                    [
                        'message' => 'the given was invalid',
                        'errors' => [
                            'password' => ["These credentials do not match our records",
                            ]
                        ],
                    ], 404
                );
            }
        } else {
            return response()->json(
                [
                    'message' => 'the given was invalid',
                    'errors' => [
                        'email' => [
                            "These credentials do not match our records"
                        ],
                    ]
                ], 401
            );
        }

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(
            [
                'message' => 'Logged out'
            ]
        );

    }

    public function updateUserImage(Request $request)
    {
        $user = Auth::user()->update(['img' => $request->image->store('public', 'public')]);
        return response()->json(
            [
                'message' => 'updated Successfully',
                'data' => ['token' => null,
                    'user' => UserResource::make(Auth::user()),
                ]
            ]
        );
    }

}
