<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $token = $request->user()->createToken('login_token');
                return response()->json([
                    'status' => true,
                    'token' => $token->plainTextToken,
                ], 200);
            }

            return response()->json([
                'status' => false,
                'messages' => 'Email dan Paswword Salah'
            ], 401);

        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ], 403);
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
