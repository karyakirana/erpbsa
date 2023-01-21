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
                    'status' => 200,
                    'token' => $token->plainTextToken,
                ]);
            }

            return response()->json([
                'status' => 401,
                'messages' => 'Email dan Paswword Salah'
            ]);

        } catch (\Exception $e){
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ]);
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
