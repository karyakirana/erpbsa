<?php

namespace App\Http\Controllers\Akuntansi;

use App\Http\Controllers\Controller;
use App\Models\Akuntansi\Akun;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index()
    {
        $data = Akun::with(['akunTipe', 'akunTipe.akunKategori']);
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => 'nullable'
        ]);
        \DB::beginTransaction();
        try {
            $store = Akun::create($data);
            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $store
            ]);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        return response()->json([
            'status' => true,
            'data' => Akun::with(['akunTipe', 'akunTipe.akunKategori'])->find($id)
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'akun_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => 'nullable'
        ]);
        \DB::beginTransaction();
        try {
            $store = Akun::find($data['akun_id'])->update($data);
            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $store
            ]);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            $destroy = Akun::destroy($id);
            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $destroy
            ]);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }
}
