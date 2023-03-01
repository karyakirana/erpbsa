<?php namespace App\ERP\Penjualan;

use App\ERP\TransactionInterface;
use App\Models\Penjualan\Penjualan;
use App\Models\Penjualan\PenjualanRetur;

class PenjualanReturService implements TransactionInterface
{

    public function kode($kondisi = "baik")
    {
        return null;
    }

    public function getById($id)
    {
        \DB::beginTransaction();
        try {
            $data = PenjualanRetur::with([])->find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getData($active_cash = true)
    {
        \DB::beginTransaction();
        try {
            $data = PenjualanRetur::with([])->get();
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getWithDeletedData($active_cash = true)
    {
        // TODO: Implement getWithDeletedData() method.
    }

    public function store(array $data)
    {
        \DB::beginTransaction();
        try {
            $store = Penjualan::create($data);
            return commit_helper($store);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $penjualan_retur = Penjualan::find($data['penjualan_retur_id']);
            return commit_helper($penjualan_retur);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            $penjualan_retur = Penjualan::find($id);
            return commit_helper($penjualan_retur);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function restoreDeletedData($id)
    {
        // TODO: Implement restoreDeletedData() method.
    }

    public function forceDestroy($id)
    {
        // TODO: Implement forceDestroy() method.
    }
}
