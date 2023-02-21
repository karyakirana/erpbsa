<?php namespace App\ERP\Keuangan;

use App\ERP\Master\MasterInterface;
use App\Models\Akuntansi\AkunTipe;

class AkunTipeService implements MasterInterface
{

    public function kode()
    {
        return null;
    }

    public function getDataById($id)
    {
        \DB::beginTransaction();
        try {
            $data = AkunTipe::with('akunKategori')->find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getData()
    {
        \DB::beginTransaction();
        try {
            $data = AkunTipe::with('akunKategori')->get();
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getDataIncludeDestroy($active_cash = true)
    {
        // TODO: Implement getDataIncludeDestroy() method.
    }

    public function store(array $data)
    {
        \DB::beginTransaction();
        try {
            $store = AkunTipe::create($data);
            return commit_helper($store);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $update = AkunTipe::find($data['akun_tipe_id']);
            $update->update($data);
            return commit_helper($update->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function softDestroy($id)
    {
        \DB::beginTransaction();
        try {
            $akunTipe = AkunTipe::destroy($id);
            return commit_helper($akunTipe);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function restoreDestroy($id)
    {
        // TODO: Implement restoreDestroy() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}
