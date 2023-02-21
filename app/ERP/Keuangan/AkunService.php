<?php namespace App\ERP\Keuangan;

use App\ERP\Master\MasterInterface;
use App\Models\Akuntansi\Akun;

class AkunService implements MasterInterface
{

    public function kode()
    {
        return;
    }

    public function getDataById($id)
    {
        \DB::beginTransaction();
        try {
            $data = Akun::with([
                'akunTipe', 'akunTipe.akunKategori'
            ])->find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getData()
    {
        \DB::beginTransaction();
        try {
            $data = Akun::with([
                'akunTipe', 'akunTipe.akunKategori'
            ])->get();
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
            $akun = Akun::create($data);
            return commit_helper($akun);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $akun = Akun::find($data['akun_id']);
            $akun->update($data);
            return commit_helper($akun);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function softDestroy($id)
    {
        \DB::beginTransaction();
        try {
            $akun = Akun::destroy($id);
            return commit_helper($akun);
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
