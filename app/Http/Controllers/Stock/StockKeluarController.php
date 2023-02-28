<?php

namespace App\Http\Controllers\Stock;

use App\ERP\Stock\StockKeluarService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockKeluarController extends Controller
{
    public StockKeluarService $stockKeluarService;

    public function __construct()
    {
        $this->stockKeluarService = new StockKeluarService();
    }

    public function index()
    {
        return $this->stockKeluarService->getData();
    }

    public function edit($id)
    {
        return $this->stockKeluarService->getById($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kondisi' => 'required',
            'draft' => 'nullable',
            'surat_jalan' => 'nullable',
            'tgl_keluar' => 'required',
            'lokasi_id' => 'required',
            'supplier_id' => 'nullable',
            'customer_id' => 'nullable',
            'total_barang' => 'required',
            'total_hpp' => 'required',
            'stock_masuk_detail' => 'required'
        ]);
        return $this->stockKeluarService->store($data);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'stock_masuk_id' => 'required',
            'kondisi' => 'required',
            'draft' => 'nullable',
            'surat_jalan' => 'nullable',
            'tgl_keluar' => 'required',
            'lokasi_id' => 'required',
            'supplier_id' => 'nullable',
            'customer_id' => 'nullable',
            'total_barang' => 'required',
            'total_hpp' => 'required',
            'stock_masuk_detail' => 'required'
        ]);
        return $this->stockKeluarService->update($data);
    }

    public function destroy($id)
    {
        return $this->stockKeluarService->destroy($id);
    }
}
