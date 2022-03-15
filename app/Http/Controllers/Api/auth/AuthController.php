<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            'img' => $request->img->store('public', 'public'),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'Longitude' => $request->Longitude,
            'Latitude' => $request->Latitude,
            'password' => Hash::make($request->password),

        ]);
        dd($user->image_link);

        //  event(new Registered($user));

        $token = $user->createToken('authtoken');

        return response()->json(
            [
                'message' => 'User Registered',
                'data' => ['token' => $token->plainTextToken, 'user' => $user]
            ]
        );

    }


    public function login(LoginRequest $request)
    {
        $request->authenticate();


        return UserResource::collection(User::all());
//return new

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

    function m()
    {
        $post = User::all();
        $post->delete();
        return response()->json(
            [
                'message' => 'Deleted Successfully ',
            ]
        );
    }
}
