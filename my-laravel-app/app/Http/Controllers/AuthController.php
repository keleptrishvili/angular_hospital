<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        // Validate request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Return response (you can also return a token here)
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    // Login and return JWT token
    public function login(Request $request)
    {
        // Validate request
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to login the user
        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            // Generate JWT token
            $token = JWTAuth::fromUser(Auth::user());

            // Return the token to the client
            return response()->json(['token' => $token], 200);
        }

        // Return error if authentication fails
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
