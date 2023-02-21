<?php

namespace App\Http\Controllers\Master;

use App\ERP\Master\ProdukKategoriService;
use App\Http\Controllers\Controller;
use App\Models\Master\ProdukKategori;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProdukKategoriController extends Controller
{
    private ProdukKategoriService $kategoriService;

    public function __construct()
    {
        $this->kategoriService = new ProdukKategoriService();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:50',
            'keterangan' => 'nullable'
        ]);
        return $this->kategoriService->store($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function view(Request $request)
    {
        return $this->kategoriService->getData();
    }

    /**
     * @param $produk_kategori_id
     * @return JsonResponse
     */
    public function edit($produk_kategori_id)
    {
        return $this->kategoriService->getDataById($produk_kategori_id);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'produk_kategori_id' => 'required',
            'nama' => 'required|max:50',
            'keterangan' => 'nullable'
        ]);
        return $this->kategoriService->update($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->kategoriService->softDestroy($id);
    }
}
