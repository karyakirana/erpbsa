<?php

namespace App\Http\Controllers\Master;

use App\ERP\Master\JabatanService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    private JabatanService $jabatanService;

    public function __construct()
    {
        $this->jabatanService = new JabatanService();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getData(Request $request)
    {
        return $this->jabatanService->getData();
    }

    /**
     * @param $jabatan_id
     * @return JsonResponse
     */
    public function edit($jabatan_id)
    {
        return $this->jabatanService->getDataById($jabatan_id);
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
        return $this->jabatanService->store($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'jabatan_id' => 'required',
            'nama' => 'required|max:50',
            'keterangan' => 'nullable'
        ]);
        return $this->jabatanService->update($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->jabatanService->softDestroy($id);
    }
}
