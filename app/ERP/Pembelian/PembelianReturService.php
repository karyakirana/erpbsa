<?php namespace App\ERP\Pembelian;

use App\ERP\TransactionInterface;
use App\Models\Pembelian\PembelianRetur;

class PembelianReturService implements TransactionInterface
{

    public function kode($kondisi = "baik")
    {
        return null;
    }

    public function getById($id)
    {
        \DB::beginTransaction();
        try {
            $data = PembelianRetur::with([])->find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getData($active_cash = true)
    {
        \DB::beginTransaction();
        try {
            $data = PembelianRetur::with([])->get();
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
            $data['active_cash'] = get_closed_cash();
            $data['kode'] = $this->kode();
            $pembelian_retur = PembelianRetur::create($data);
            return commit_helper($pembelian_retur);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $pembelian_retur = PembelianRetur::find($data['pembelian_retur_id']);
            return commit_helper($pembelian_retur);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
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
