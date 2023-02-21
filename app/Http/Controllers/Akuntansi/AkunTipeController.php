<?php

namespace App\Http\Controllers\Akuntansi;

use App\ERP\Keuangan\AkunTipeService;
use App\Http\Controllers\Controller;
use App\Models\Akuntansi\AkunTipe;
use Illuminate\Http\Request;

class AkunTipeController extends Controller
{
    private AkunTipeService $akunTipeService;

    public function __construct()
    {
        $this->akunTipeService = new AkunTipeService();
    }

    public function index()
    {
        return $this->akunTipeService->getData();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => 'nullable'
        ]);
        return $this->akunTipeService->store($data);
    }

    public function edit($id)
    {
        return $this->akunTipeService->getDataById($id);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'akun_kategori_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => 'nullable'
        ]);
        return $this->akunTipeService->update($data);
    }

    public function destroy($id)
    {
        return $this->akunTipeService->softDestroy($id);
    }
}
