<?php

namespace App\Http\Controllers\Akuntansi;

use App\ERP\Keuangan\CoaConfigService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoaConfigController extends Controller
{
    private CoaConfigService $coaConfigService;

    public function __construct()
    {
        $this->coaConfigService = new CoaConfigService();
    }

    public function index()
    {
        return $this->coaConfigService->getData();
    }

    public function edit($id)
    {
        return $this->coaConfigService->getByConfig($id);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'config' => 'required',
            'akun_id' => 'required',
            'default_field' => 'required'
        ]);
        return $this->coaConfigService->updateByConfig($data);
    }
}
