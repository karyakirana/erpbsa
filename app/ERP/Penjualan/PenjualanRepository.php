<?php namespace App\ERP\Penjualan;

use App\ERP\Keuangan\CoaTrait;
use App\Models\Penjualan\Penjualan;

class PenjualanRepository
{
    use CoaTrait;

    private $coa_penjualan_id, $coa_field_penjualan;
    private $coa_piutang_id, $coa_field_piutang;

    public function __construct()
    {
        $coa_piutang = $this->getCoaConfig('piutang_penjualan');
        $this->coa_piutang_id = $coa_piutang->akun_id;
        $this->coa_field_piutang = $coa_piutang->default_field;
        $coa_penjualan = $this->getCoaConfig('penjualan');
        $this->coa_penjualan_id = $coa_penjualan->akun_id;
        $this->coa_field_penjualan = $coa_penjualan->default_field;
    }

    // generate code
    private function kode()
    {
        return null;
    }

    public function handleStore(array $data)
    {
        // store transaction
        $data['active_cash'] = get_closed_cash();
        $data['kode'] = $this->kode();
        $penjualan = Penjualan::create($data);
        // store transaction detail
    }
}
