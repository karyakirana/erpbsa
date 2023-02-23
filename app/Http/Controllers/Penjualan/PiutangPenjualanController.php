<?php

namespace App\Http\Controllers\Penjualan;

use App\ERP\Pembelian\HutangPembelianService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PiutangPenjualanController extends Controller
{
    private HutangPembelianService $hutangPembelianService;

    public function __construct()
    {
        $this->hutangPembelianService = new HutangPembelianService();
    }

    public function index()
    {
        return $this->hutangPembelianService->getData();
    }

    public function edit($id)
    {
        return $this->hutangPembelianService->getById($id);
    }
}
