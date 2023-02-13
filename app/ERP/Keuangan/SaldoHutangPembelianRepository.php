<?php namespace App\ERP\Keuangan;

use App\Models\Keuangan\SaldoHutangPembelian;

class SaldoHutangPembelianRepository
{
    public $supplier_id;
    public $saldo;

    public function __construct($supplier_id, $saldo)
    {
        $this->supplier_id = $supplier_id;
        $this->saldo = $saldo;
    }

    // insert hutang baru
    private function create()
    {
        return SaldoHutangPembelian::create([
            'supplier_id' => $this->supplier_id,
            'saldo' => $this->saldo
        ]);
    }

    // update or create
    public function update()
    {
        $query = SaldoHutangPembelian::find($this->supplier_id);
        if (!is_null($query)){
            $query->increment('saldo', $this->saldo);
        }
        return $this->create();
    }

    // rollback hutang
    public function rollback()
    {
        return SaldoHutangPembelian::find($this->supplier_id)->decrement('saldo', $this->saldo);
    }
}
