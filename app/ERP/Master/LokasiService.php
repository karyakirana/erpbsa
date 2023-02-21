<?php namespace App\ERP\Master;

use App\Models\Master\Lokasi;

class LokasiService implements MasterInterface
{
    public function kode()
    {
        $lokasi = new Lokasi();
        return master_kode_helper($lokasi, 'L');
    }

    public function getDataById($id)
    {
        \DB::beginTransaction();
        try {
            $data = Lokasi::find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getData()
    {
        \DB::beginTransaction();
        try {
            $data = Lokasi::all();
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
            $data['kode'] = $this->kode();
            $lokasi = Lokasi::create($data);
            return commit_helper($lokasi);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $lokasi = Lokasi::find($data['lokasi_id']);
            $lokasi->update($data);
            return commit_helper($lokasi->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function softDestroy($id)
    {
        \DB::beginTransaction();
        try {
            $data = Lokasi::destroy($id);
            return commit_helper($data);
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
