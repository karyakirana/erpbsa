<?php

namespace App\Http\Controllers\Master;

use App\ERP\Master\LokasiService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    private LokasiService $lokasiService;

    public function __construct()
    {
        $this->lokasiService = new LokasiService();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getData(Request $request)
    {
        return $this->lokasiService->getData();
    }

    /**
     * @param $lokasi_id
     * @return JsonResponse
     */
    public function edit($lokasi_id)
    {
        return $this->lokasiService->getDataById($lokasi_id);
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
        return $this->lokasiService->store($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'lokasi_id' => 'required',
            'nama' => 'required|max:50',
            'keterangan' => 'nullable'
        ]);

        return $this->lokasiService->update($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->lokasiService->softDestroy($id);
    }
}
