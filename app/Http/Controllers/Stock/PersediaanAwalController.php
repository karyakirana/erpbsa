<?php

namespace App\Http\Controllers\Stock;

use App\ERP\Stock\PersediaanAwalService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersediaanAwalController extends Controller
{
    private PersediaanAwalService $persediaanAwalService;

    public function __construct()
    {
        $this->persediaanAwalService = new PersediaanAwalService();
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
            'kondisi' => 'required',
            'tgl_persediaan_awal' => 'required',
            'lokasi_id' => 'required',
            'total_barang' => 'required|numeric',
            'total_nominal' => 'required|numeric',
            'keterangan' => 'nullable',
            'data_detail' => 'array'
        ]);
        return $this->persediaanAwalService->store($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        return $this->persediaanAwalService->getData();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $persediaan_awal_id
     * @return JsonResponse
     */
    public function edit($persediaan_awal_id)
    {
        return $this->persediaanAwalService->getById($persediaan_awal_id);
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
            'persediaan_awal_id' => 'required',
            'kondisi' => 'required',
            'tgl_persediaan_awal' => 'required',
            'lokasi_id' => 'required',
            'user_id' => 'required',
            'total_barang' => 'required|numeric',
            'total_nominal' => 'required|numeric',
            'keterangan' => 'nullable'
        ]);
        return $this->persediaanAwalService->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->persediaanAwalService->destroy($id);
    }
}
