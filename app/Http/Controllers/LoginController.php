<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        if ($request->expectsJson()) {
            return redirect()->to('/');
        }

        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::check()){
                $token = $request->user()->createToken('login_token');
                return response()->json([
                    'status' => true,
                    'token' => $token->plainTextToken
                ], 200);
            }

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $token = $request->user()->createToken('login_token');
                return response()->json([
                    'status' => true,
                    'token' => $token->plainTextToken,
                ], 200);
            }

            if (!Auth::attempt($credentials)){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match',
                ], 401);
            }

            return response()->json([
                'status' => false,
                'messages' => 'Login Tidak Bisa'
            ], 401);

        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ], 500);
        }
    }

    public function register()
    {
        // register
    }

    public function destroy()
    {
        // logout
    }
}
