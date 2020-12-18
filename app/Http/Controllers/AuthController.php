<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
            'email' => 'email|required',
            'password' => 'required'
            ]);
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid Email or Password'
            ], 500);
            }
            $user = User::where('email', $request->email)->first();
            if ( ! Hash::check($request->password, $user->password, [])) {
            throw new \Exception('Error in Login');
            }
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            ], 200);
        } catch (Exception $error) {
            return response()->json([
            'message' => 'Error in Login',
            'error' => $error,
            ], 500);
        }
    }

    public function logout(){
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([
        'message' => 'Successfully logged out!',
        ], 200);
    }
}
