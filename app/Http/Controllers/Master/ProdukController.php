<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    protected function kode()
    {
        $query = Produk::latest('kode')->first();
        if (!$query){
            $num = 1;
        } else {
            $lastNum = (int) $query->last_num_master;
            $num = $lastNum + 1;
        }
        return "P".sprintf("%05s", $num);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produk_kategori_id' => 'required',
            'nama' => 'required|max:100',
            'tipe' => 'nullable',
            'merk' => 'required|max:50',
            'satuan_jual' => 'required|max:20',
            'harga' => 'required|numeric',
            'max_diskon' => 'required|numeric',
            'buffer_stock' => 'required|numeric',
            'minimum_stock' => 'required|numeric',
            'keterangan' => 'nullable',
        ]);
        $data['kode'] = $this->kode();
        $data['status'] = 'active';
        \DB::beginTransaction();
        try {
            $produk = Produk::create($data);
            if (count($request->produk_kemasan) > 0){
                $produk->produkKemasan()->createMany($request->produk_kemasan);
            }
            if (count($request->produk_image) > 0){
                $produk->produkImage()->createMany($request->produk_image);
            }
            \DB::commit();
            return response()->json([
                'status' => 200,
                'data' => $produk
            ]);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function view(Request $request)
    {
        try {
            $query = Produk::query()->with(['produkKategori', 'produkKemasan', 'produkKemasan']);
            if (!is_null($request->search)){
                $query->where('nama', 'like', '%'.$request->search.'%')
                    ->orWhereRelation('produkKategori', 'nama', 'like', '%'.$request->search.'%')
                    ->orWhere('tipe', 'like', '%'.$request->search.'%')
                    ->orWhere('merk', 'like', '%'.$request->search.'%')
                    ->orWhere('harga', 'like', '%'.$request->search.'%')
                    ->orWhere('keterangan', 'like', '%'.$request->search.'%');
            }
            return response()->json([
                'status' => 200,
                'data' => $query->get()
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function edit($produk_id)
    {
        try {
            $query = Produk::find($produk_id)->with(['produkKategori', 'produkKemasan', 'produkKemasan']);
            return response()->json([
                'status' => 200,
                'data' => $query
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'produk_id' => 'required',
            'produk_kategori_id' => 'required',
            'nama' => 'required|max:100',
            'tipe' => 'nullable',
            'merk' => 'required|max:50',
            'satuan_jual' => 'required|max:20',
            'harga' => 'required|numeric',
            'max_diskon' => 'required|numeric',
            'buffer_stock' => 'required|numeric',
            'minimum_stock' => 'required|numeric',
            'keterangan' => 'nullable',
        ]);
        \DB::beginTransaction();
        try {
            $query = Produk::find($data['produk_id']);
            $query->produkKemasan()->delete();
            $query->produkImage()->delete();
            $query->update($data);
            if (count($request->produk_kemasan) > 0){
                $query->produkKemasan()->createMany($request->produk_kemasan);
            }
            if (count($request->produk_image) > 0){
                $query->produkImage()->createMany($request->produk_image);
            }
            return response()->json([
                'status' => 200,
                'data' => $query->refresh()
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $query = Produk::find($request->produk_id);
            $query->produkKemasan()->delete();
            $query->produkImage()->delete();
            $query->delete();
            return response()->json([
                'status' => 200,
                'messages' => 'Data sudah di hapus'
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ]);
        }
    }
}
