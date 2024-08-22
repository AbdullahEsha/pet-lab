<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CredentialController extends Controller
{
    public function register(Request $request)
    {
        $registerUser = $request->all();

        // if has file then upload it
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/user'), $imageName);
            $registerUser['image'] = 'images/user/' . $imageName;
        }
        // hash the password
        if(isset($registerUser['password'])){
            $registerUser['password'] = Hash::make($registerUser['password']);
        }

        $user = User::create($registerUser);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        // set data so that i can call it by using this "$request->user()"
        $credentials = $request->only('labId', 'password') ?? $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        $user->token = $token;
        $user->save();

        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json([
                'message' => 'User logged out successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'user' => $request->user()
            ], 500);
        }
    }
}
