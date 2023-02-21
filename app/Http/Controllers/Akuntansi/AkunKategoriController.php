<?php

namespace App\Http\Controllers\Akuntansi;

use App\ERP\Keuangan\AkunKategoriService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AkunKategoriController extends Controller
{
    private AkunKategoriService $akunKategoriService;

    public function __construct()
    {
        $this->akunKategoriService = new AkunKategoriService();
    }

    public function index()
    {
        return $this->akunKategoriService->getData();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => 'nullable'
        ]);
        return $this->akunKategoriService->store($data);
    }

    public function edit($id)
    {
        return $this->akunKategoriService->getDataById($id);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'akun_kategori_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => 'nullable'
        ]);
        return $this->akunKategoriService->update($data);
    }

    public function destroy($id)
    {
        return $this->akunKategoriService->softDestroy($id);
    }
}
