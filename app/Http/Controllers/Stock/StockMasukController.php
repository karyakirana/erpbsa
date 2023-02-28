<?php

namespace App\Http\Controllers\Stock;

use App\ERP\Stock\StockMasukService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockMasukController extends Controller
{
    private StockMasukService $stockMasukService;

    public function __construct()
    {
        $this->stockMasukService = new StockMasukService();
    }

    public function index()
    {
        return $this->stockMasukService->getData();
    }

    public function edit($id)
    {
        return $this->stockMasukService->getById($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'draft' => 'nullable',
            'kondisi' => 'required',
            'surat_jalan' => 'required',
            'tgl_masuk' => 'required',
            'lokasi_id' => 'required',
            'supplier_id' => 'nullable',
            'customer_id' => 'nullable',
            'total_barang' => 'required',
            'total_hpp' => 'required',
            'keterangan' => 'nullable',
            'stock_masuk_detail' => 'required'
        ]);
        return $this->stockMasukService->store($data);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'stock_masuk_id' => 'nullable',
            'draft' => 'nullable',
            'kondisi' => 'required',
            'surat_jalan' => 'required',
            'tgl_masuk' => 'required',
            'lokasi_id' => 'required',
            'supplier_id' => 'nullable',
            'customer_id' => 'nullable',
            'total_barang' => 'required',
            'total_hpp' => 'required',
            'keterangan' => 'nullable',
            'stock_masuk_detail' => 'required'
        ]);
        return $this->stockMasukService->update($data);
    }
}
