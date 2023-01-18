<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\ProdukKategori;
use Illuminate\Http\Request;

class ProdukKategoriController extends Controller
{
    protected function kode()
    {
        $data = ProdukKategori::latest('kode')->first();
        if (!$data){
            $num = 1;
        } else {
            $lastNum = (int) $data->last_num_master;
            $num = $lastNum + 1;
        }
        return "K".sprintf("%05s", $num);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:50',
            'keterangan' => 'nullable'
        ]);
        $data['kode'] = $this->kode();
        try {
            $query = ProdukKategori::create($data);
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
            $query = ProdukKategori::query();
            if (!is_null($request->search)){
                $query->where('nama', 'like', '%'.$request->search.'%')
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

    public function edit($produk_kategori_id)
    {
        try {
            $query = ProdukKategori::find($produk_kategori_id);
            return response()->json([
                'status' => true,
                'data' => $query
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ], 403);
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'produk_kategori_id' => 'required',
            'nama' => 'required|max:50',
            'keterangan' => 'nullable'
        ]);

        try {
            $query = ProdukKategori::find($data['produk_kategori_id'])->update($data);
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
            $query = ProdukKategori::destroy($id);
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
