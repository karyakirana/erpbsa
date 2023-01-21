<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;
use App\Models\ClosedCash;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function store(Request $request)
    {
       try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $token = $request->user()->createToken('login_token');
                // check and add session closed cash
                $idUser = Auth::id();
                $request->session()->put('ClosedCash', $this->ClosedCash($idUser));

                return response()->json([
                    'status' => true,
                    'token' => $token->plainTextToken,
                ], 200);
            }
        } catch (ValidationException|\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
        return response()->json([
            'status'=> false
        ], 500);
    }

    public function register()
    {
        // register
    }

    public function destroy()
    {
        // logout
    }

    /**
     * Handle Closed Cashed after login to session
     * @param number ID USER
     * @return string Active Closed id
     */
    public function ClosedCash($idUser)
    {
        $data = ClosedCash::whereNull('closed')->latest()->first();
        if ($data) {
            // jika null maka buat data
            return $data->active;
        }
        $generateClosedCash = md5(now());
        $isi = [
            'active' => $generateClosedCash,
            'user_id' => $idUser,
        ];
        $createData = ClosedCash::create($isi);
        return $generateClosedCash;

    }
}
