<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected function kode()
    {
        $data = Supplier::latest('kode')->first();
        if (!$data){
            $num = 1;
        } else {
            $lastNum = (int) $data->last_num_master;
            $num = $lastNum + 1;
        }
        return "S".sprintf("%05s", $num);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:50',
            'telepon' => 'required|max:20',
            'email' => 'nullable|max:50',
            'npwp' => 'nullable|max:20',
            'alamat' => 'required',
            'kota_id' => 'required',
            'keterangan' => 'nullable'
        ]);
        $data ['kode'] = $this->kode();
        try {
            $query = Supplier::create($data);
            return response()->json([
                'status' => true,
                'data' => $query
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function view(Request $request)
    {
        try {
            $query = Supplier::query()->with(['kota']);
            if (!is_null($request->search)){
                $query->where('nama', 'like', '%'.$request->search.'%')
                    ->orWhere('telepon', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%')
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

    public function edit($supplier_id)
    {
        try {
            $query = Supplier::with(['kota'])->find($supplier_id);
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
            'supplier_id' => 'required',
            'nama' => 'required|max:50',
            'telepon' => 'required|max:20',
            'email' => 'nullable|max:50',
            'npwp' => 'nullable|max:20',
            'alamat' => 'required',
            'kota_id' => 'required',
            'keterangan' => 'nullable'
        ]);
        try {
            $query = Supplier::find($data['supplier_id'])->update($data);
            return response()->json([
                'status' => true,
                'data' => $query
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $query = Supplier::destroy($id);
            return response()->json([
                'status' => true,
                'messages' => 'Data sudah di hapus'
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ], 403);
        }
    }
}
