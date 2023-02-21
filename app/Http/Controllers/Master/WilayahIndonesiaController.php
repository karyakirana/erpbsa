<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Regency;
use Illuminate\Http\Request;

class WilayahIndonesiaController extends Controller
{
    public function kotaIndonesia()
    {
        try {
            $kota = Regency::with('province');
            return response()->json([
                'status' => true,
                'data' => $kota->get()
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }
}
