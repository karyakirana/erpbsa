<?php

namespace App\Http\Controllers\Penjualan;

use App\ERP\Penjualan\PenjualanService;
use App\Http\Controllers\Controller;
use App\Models\Penjualan\Penjualan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    private PenjualanService $service;

    public function __construct()
    {
        $this->service = new PenjualanService();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'penjualan_penawaran_id' => 'nullable',
            'draft' => 'boolean',
            'status' => 'required',
            'tipe_penjualan' => 'required',
            'tgl_penjualan' => 'required',
            'tempo' => 'nullable',
            'tgl_tempo' => 'nullable',
            'customer_id' => 'required',
            'sales_id' => 'required',
            'total_barang' => 'required',
            'ppn' => 'nullable',
            'biaya_lain' => 'nullable',
            'total_bayar' => 'required',
            'keterangan' => 'nullable',
            'penjualan_detail_store' => 'required|array'
        ]);
        return $this->service->store($data);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        return $this->service->getData();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $penjualan_id
     * @return JsonResponse
     */
    public function edit($penjualan_id)
    {
        return $this->service->getById($penjualan_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'penjualan_id' => 'nullable',
            'penjualan_penawaran_id' => 'nullable',
            'draft' => 'boolean',
            'status' => 'required',
            'tipe_penjualan' => 'required',
            'tgl_penjualan' => 'required',
            'tempo' => 'nullable',
            'tgl_tempo' => 'nullable',
            'customer_id' => 'required',
            'sales_id' => 'required',
            'total_barang' => 'required',
            'ppn' => 'nullable',
            'biaya_lain' => 'nullable',
            'total_bayar' => 'required',
            'keterangan' => 'nullable',
            'penjualan_detail_store' => 'required|array'
        ]);
        return $this->service->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
