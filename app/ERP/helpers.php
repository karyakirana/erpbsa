<?php

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
