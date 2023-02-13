<?php

namespace App\Http\Controllers\Akuntansi;

use App\Http\Controllers\Controller;
use App\Models\Akuntansi\AkunKategori;
use Illuminate\Http\Request;

class AkunKategoriController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                'status' => true,
                'data' => AkunKategori::all()
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'messages' => $e->getMessage()
            ]);
        }
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
            $store = AkunKategori::create($data);
            \DB::commit();
            return response()->json([
                'status' => true,
                '$data' => $store
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $data = AkunKategori::find($id);
        try {
            return response()->json([
                'status' => true,
                '$data' => $data
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'akun_kategori_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => 'nullable'
        ]);
        \DB::beginTransaction();
        try {
            $update = AkunKategori::find($data['akun_kategori_id'])->update($data);
            \DB::commit();
            return response()->json([
                'status' => true,
                '$data' => $update
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            $update = AkunKategori::destroy($id);
            \DB::commit();
            return response()->json([
                'status' => true,
                '$data' => $update
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'messages' => $e->getMessage()
            ]);
        }
    }
}
