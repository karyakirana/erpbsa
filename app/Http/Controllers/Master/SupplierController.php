<?php

namespace App\Http\Controllers\Master;

use App\ERP\Master\SupplierService;
use App\Http\Controllers\Controller;
use App\Models\Master\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private SupplierService $service;

    public function __construct()
    {
        $this->service = new SupplierService();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:50',
            'telepon' => 'required|max:20',
            'email' => 'nullable|max:50',
            'npwp' => 'nullable|max:20',
            'alamat' => 'required',
            'kota_id' => 'required',
            'keterangan' => 'nullable'
        ]);
        return $this->service->store($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function view(Request $request)
    {
        return $this->service->getData();
    }

    /**
     * @param $supplier_id
     * @return JsonResponse
     */
    public function edit($supplier_id)
    {
        return $this->service->getDataById($supplier_id);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => 'required',
            'nama' => 'required|max:50',
            'telepon' => 'required|max:20',
            'email' => 'nullable|max:50',
            'npwp' => 'nullable|max:20',
            'alamat' => 'required',
            'kota_id' => 'required',
            'keterangan' => 'nullable'
        ]);
        return $this->service->update($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->service->softDestroy($id);
    }
}
