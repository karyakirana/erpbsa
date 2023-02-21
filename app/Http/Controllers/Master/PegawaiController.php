<?php

namespace App\Http\Controllers\Master;

use App\ERP\Master\PegawaiService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    private PegawaiService $pegawaiService;

    public function __construct()
    {
        $this->pegawaiService = new PegawaiService();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:50',
            'gender' => 'required|max:10',
            'telepon' => 'required|max:20',
            'email' => 'required|email|max:20',
            'npwp' => 'nullable|max:20',
            'jabatan_id' => 'required',
            'alamat' => 'required',
            'kota_id' => 'required',
            'keterangan' => 'nullable'
        ]);
        return $this->pegawaiService->store($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function view(Request $request)
    {
        return $this->pegawaiService->getData();
    }

    /**
     * @param $pegawai_id
     * @return JsonResponse
     */
    public function edit($pegawai_id)
    {
        return $this->pegawaiService->getDataById($pegawai_id);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'pegawai_id' => 'required',
            'nama' => 'required|max:50',
            'gender' => 'required|max:10',
            'telepon' => 'required|max:20',
            'email' => 'required|email|max:20',
            'npwp' => 'nullable|max:20',
            'jabatan_id' => 'required',
            'alamat' => 'required',
            'kota_id' => 'required',
            'keterangan' => 'nullable'
        ]);

        return $this->pegawaiService->update($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->pegawaiService->softDestroy($id);
    }
}
