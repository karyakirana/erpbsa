<?php namespace App\ERP\Master;

use App\Models\Regency;

class KotaService implements MasterInterface
{
    public function kode()
    {
        // TODO: Implement kode() method.
    }

    public function getDataById($id)
    {
        \DB::beginTransaction();
        try {
            $data = Regency::find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getData()
    {
        \DB::beginTransaction();
        try {
            $data = Regency::with([
                'province'
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
        // TODO: Implement store() method.
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function softDestroy($id)
    {
        // TODO: Implement softDestroy() method.
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
