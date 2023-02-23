<?php namespace App\ERP\Penjualan;

use App\ERP\HutangPiutangInterface;
use App\Models\Keuangan\PiutangPenjualan;

class PiutangPenjualanService implements HutangPiutangInterface
{
    public function getData()
    {
        \DB::beginTransaction();
        try {
            $data = PiutangPenjualan::with([
                'saldoPiutang',
                'saldoPiutang.customer',
                'piutangablePenjualan'
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
            $data = PiutangPenjualan::with([
                'saldoPiutang',
                'saldoPiutang.customer',
                'piutangablePenjualan'
            ])->find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }
}
