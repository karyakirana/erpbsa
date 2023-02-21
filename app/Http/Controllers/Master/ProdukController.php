<?php

namespace App\Http\Controllers\Master;

use App\ERP\Master\ProdukService;
use App\Http\Controllers\Controller;
use App\Models\Master\Produk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    private ProdukService $produkService;

    public function __construct()
    {
        $this->produkService = new ProdukService();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
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
            'produk_kemasan_beli' => 'nullable|array',
            'produk_image' => 'nullable|array'
        ]);
        return $this->produkService->store($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function view(Request $request)
    {
        return $this->produkService->getData();
    }

    public function edit($produk_id)
    {
        return $this->produkService->getDataById($produk_id);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'produk_id' => 'required',
            'produk_kategori_id' => 'required',
            'nama' => 'required|max:100',
            'tipe' => 'nullable',
            'merk' => 'required|max:50',
            'satuan_jual' => 'required|string|max:20',
            'harga' => 'required|numeric',
            'max_diskon' => 'required|numeric',
            'buffer_stock' => 'required|numeric',
            'minimum_stock' => 'required|numeric',
            'keterangan' => 'nullable',
            'produk_kemasan_beli' => 'nullable|array',
            'produk_image' => 'nullable|array'
        ]);
        return $this->produkService->update($data);
    }

    public function destroy($id)
    {
        return $this->produkService->softDestroy($id);
    }
}
