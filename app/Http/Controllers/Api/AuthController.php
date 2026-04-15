<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credentials ghalat hain bhai!'], 401);
        }

        // ✅ Token generate ho raha hai
        $token = $user->createToken('blog_token')->plainTextToken;

        return response()->json([
            'user' => $user->name,
            'token' => $token, // Ye token frontend wala apne paas save kar lega
        ]);
    }

    public function logout(Request $request)
    {
        // Current token delete kar dein
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully!']);
    }
}
