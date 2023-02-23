<?php

namespace App\Http\Controllers\Master;

use App\ERP\Master\CustomerService;
use App\Http\Controllers\Controller;
use App\Models\Master\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private CustomerService $customerService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis_instansi' => 'required|max:20',
            'nama' => 'required|max:50',
            'telepon' => 'required|max:20',
            'email' => 'nullable|email',
            'npwp' => 'nullable|max:20',
            'alamat' => 'required',
            'kota_id' => 'required',
            'sales_id' => 'required',
            'diskon' => 'required',
            'keterangan' => 'nullable',
        ]);
        return $this->customerService->store($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function view(Request $request)
    {
        return $this->customerService->getData();
    }

    /**
     * @param $customer_id
     * @return JsonResponse
     */
    public function edit($customer_id)
    {
        return $this->customerService->getDataById($customer_id);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required',
            'jenis_instansi' => 'required|max:20',
            'nama' => 'required|max:50',
            'telepon' => 'required|max:20',
            'email' => 'required|email',
            'npwp' => 'nullable|max:20',
            'alamat' => 'required',
            'kota_id' => 'required',
            'sales_id' => 'required',
            'diskon' => 'required',
            'keterangan' => 'nullable',
        ]);
        return $this->customerService->update($data);
    }

    public function destroy($id)
    {
        return $this->customerService->softDestroy($id);
    }
}
