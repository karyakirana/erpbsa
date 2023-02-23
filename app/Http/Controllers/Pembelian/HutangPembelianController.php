<?php

namespace App\Http\Controllers\Pembelian;

use App\ERP\Pembelian\HutangPembelianService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HutangPembelianController extends Controller
{
    private HutangPembelianService $hutangPembelian;

    public function __construct()
    {
        $this->hutangPembelian = new HutangPembelianService();
    }

    public function index()
    {
        return $this->hutangPembelian->getData();
    }

    public function edit($id)
    {
        return $this->hutangPembelian->getById($id);
    }
}
