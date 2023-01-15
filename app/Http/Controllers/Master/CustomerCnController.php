<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\CustomerCn;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CustomerCnController extends Controller
{
    // get data all customer
    public function index()
    {
        return response(CustomerCn::all(), 200);
    }

    public function edit($customer_id)
    {
        return json_encode([
            'status' => 200,
            'data' => CustomerCn::find($customer_id)->toJson()
        ]);
    }

    public function store(Request $request)
    {
        //
    }
}
