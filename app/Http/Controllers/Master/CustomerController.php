<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function kode()
    {
        $query = Customer::latest('kode')->first();
        if (!$query){
            $num = 1;
        } else {
            $lastNum = (int) $query->last_num_master;
            $num = $lastNum + 1;
        }
        return "C".sprintf("%05s", $num);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis_instansi' => 'required|max:20',
            'nama' => 'required|max:50',
            'telepon' => 'required|max:20',
            'email' => 'required|email|max:20',
            'npwp' => 'nullable|max:20',
            'alamat' => 'required',
            'kota_id' => 'required',
            'sales_id' => 'required',
            'diskon' => 'required',
            'keterangan' => 'nullable',
        ]);
        $data['kode'] = $this->kode();
        try {
            $query = Customer::create($data);
            return response()->json([
                'status' => true,
                'data' => $query
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ], 403);
        }
    }

    public function view(Request $request)
    {
        try {
            $query = Customer::query()->with(['sales', 'kota']);
            if (!is_null($request->search)){
                $query->where('nama', 'like', '%'.$request->search.'%')
                    ->orWhereRelation('sales', 'nama', 'like', '%'.$request->search.'%')
                    ->orWhere('telepon', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%')
                    ->orWhere('alamat', 'like', '%'.$request->search.'%')
                    ->orWhere('keterangan', 'like', '%'.$request->search.'%');
            }
            return response()->json([
                'status' => true,
                'data' => $query->get()
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ], 403);
        }
    }

    public function edit($customer_id)
    {
        try {
            $query = Customer::with(['sales', 'kota'])->find($customer_id);
            return response()->json([
                'status' => true,
                'data' => $query
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ], 403);
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required',
            'jenis_instansi' => 'required|max:20',
            'nama' => 'required|max:50',
            'telepon' => 'required|max:20',
            'email' => 'required|email|max:20',
            'npwp' => 'nullable|max:20',
            'alamat' => 'required',
            'kota_id' => 'required',
            'sales_id' => 'required',
            'diskon' => 'required',
            'keterangan' => 'nullable',
        ]);
        try {
            $query = Customer::find($data['customer_id'])->update($data);
            return response()->json([
                'status' => true,
                'data' => $query
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ], 403);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $query = Customer::where('id', $request->id)->delete();
            return response()->json([
                'status' => true,
                'messages' => 'Data sudah di hapus',
                'response' => $query
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ], 403);
        }
    }
}
