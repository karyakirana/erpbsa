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

if(!function_exists("exception_rollback_helper")){
    function exception_rollback_helper(Exception $e){
        DB::rollBack();
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
}

if (!function_exists("commit_helper")){
    function commit_helper($something){
        DB::commit();
        return response()->json([
            'status' => true,
            'data' => $something
        ]);
    }
}

if (!function_exists("master_kode_helper")){
    function master_kode_helper($model, $prefix){
        $model = $model::latest('kode')->first();
        if (is_null($model)){
            $num = 1;
        } else {
            $lastNum = (int) $model->last_num_master;
            $num = $lastNum + 1;
        }
        return $prefix.sprintf("%05s", $num);
    }
}

if (!function_exists("trans_kode_helper")){
    function trans_kode_helper($model, $prefix, $kondisi = NULL){
        $query = $model::query()
            ->where('active_cash', get_closed_cash());
        if (!is_null($kondisi)){
            $query = $query->where('kondisi', $kondisi)->latest('kode');
            $kodeKondisi = ($kondisi == 'baik') ? $prefix : $prefix.'R';
            if ($query->doesntExist()){
                return "0001/{$kodeKondisi}/".date('Y');
            }

            $num = (int) $query->first()->last_num_trans + 1;
            return sprintf("%04s", $num)."/{$kodeKondisi}/".date('Y');
        }
        $query = $query->latest('kode');
        $num = (int) $query->first()->last_num_trans + 1;
        return sprintf("%04s", $num)."/{$prefix}/".date('Y');
    }
}
