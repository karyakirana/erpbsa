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

    private function create()
    {
        return SaldoPiutangPenjualan::create([
            'customer_id' => $this->customer_id,
            'saldo' => $this->saldo
        ]);
    }

    public function increment()
    {
        $query = SaldoPiutangPenjualan::find($this->customer_id);
        if (is_null($query)){
            return $this->create();
        }
        return $query->increment('saldo', $this->saldo);
    }

    public function decrement()
    {
        return SaldoPiutangPenjualan::find($this->customer_id)->decrement('saldo', $this->saldo);
    }
}
