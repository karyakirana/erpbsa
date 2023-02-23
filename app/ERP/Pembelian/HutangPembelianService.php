<?php namespace App\ERP\Pembelian;

use App\ERP\HutangPiutangInterface;
use App\Models\Keuangan\HutangPembelian;

class HutangPembelianService implements HutangPiutangInterface
{

    public function getData()
    {
        \DB::beginTransaction();
        try {
            $data = HutangPembelian::with([
                'saldoHutang',
                'saldoHutang.supplier',
                'hutangablePembelian'
            ])->get();
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getById($id)
    {
        \DB::beginTransaction();
        try {
            $data = HutangPembelian::with([
                'saldoHutang',
                'saldoHutang.supplier',
                'hutangablePembelian'
            ])->find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }
}
