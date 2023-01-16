<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Stock\Persediaan;
use Illuminate\Http\Request;

class PersediaanController extends Controller
{
    public function getData()
    {
        try {
            $persediaan = Persediaan::with(['produk'])
                ->where('active_cash', session('ClosedCash'))
                ->get();
            return response()->json([
                'status' => true,
                'data' => $persediaan
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ], 403);
        }
    }
}
