<?php

use App\Models\ClosedCash;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

if (!function_exists('json_response_200')){
    function json_response_200($data)
    {
        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }
}

if (!function_exists('json_response_fail')){
    function json_response_fail($messages, $status_code)
    {
        return response()->json([
            'status' => false,
            'messages' => $messages
        ]);
    }
}

if (!function_exists('json_response_validation')){
    function json_response_validation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => "validation error",
            'data' => $validator->errors()
        ]), 422);
    }
}

if (!function_exists("set_closed_cash")){
    function set_closed_cash($idUser)
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

if(!function_exists("get_closed_cash")){
    function get_closed_cash()
    {
        $data = ClosedCash::whereNull('closed')->latest()->first();
        return $data->active;
    }
}
