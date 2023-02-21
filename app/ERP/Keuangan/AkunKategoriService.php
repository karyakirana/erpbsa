<?php namespace App\ERP\Keuangan;

use App\ERP\Master\MasterInterface;
use App\Models\Akuntansi\AkunKategori;

class AkunKategoriService implements MasterInterface
{

    public function kode()
    {
        return;
    }

    public function getDataById($id)
    {
        \DB::beginTransaction();
        try {
            $data = AkunKategori::find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getData()
    {
        \DB::beginTransaction();
        try {
            $data = AkunKategori::all();
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
            $store = AkunKategori::create($data);
            return commit_helper($store);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $update = AkunKategori::find($data['akun_kategori_id']);
            $update->update($data);
            return commit_helper($update);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function softDestroy($id)
    {
        \DB::beginTransaction();
        try {
            $destroy = AkunKategori::destroy($id);
            return commit_helper($destroy);
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
