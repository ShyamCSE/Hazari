<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle user login and issue token.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'token'   => $user->createToken('mobile-token')->plainTextToken,
            'user'    => $user,
        ]);
    }

    /**
     * Logout and revoke the token.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Logged out successfully',
        ]);
    }

    /**
     * Get logged in user profile.
     */
    public function profile(Request $request)
    {
        return response()->json([
            'status' => true,
            'user'   => $request->user(),
        ]);
    }
}
