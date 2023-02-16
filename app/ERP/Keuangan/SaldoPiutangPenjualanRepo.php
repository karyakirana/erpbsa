<?php namespace App\ERP\Keuangan;

use App\Models\Keuangan\SaldoPiutangPenjualan;

class SaldoPiutangPenjualanRepo
{
    public $customer_id;
    public $saldo;

    public function __construct($customer_id, $saldo)
    {
        $this->customer_id = $customer_id;
        $this->saldo = $saldo;
    }

    public function create()
    {
        return SaldoPiutangPenjualan::create();
    }
}
