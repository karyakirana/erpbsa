<?php namespace App\ERP\Master;

use App\Models\Master\Supplier;

class SupplierService implements MasterInterface
{
    public function kode()
    {
        $supplier = new Supplier();
        return master_kode_helper($supplier, 'S');
    }

    public function getDataById($id)
    {
        \DB::beginTransaction();
        try {
            $data = Supplier::with([
                'kota'
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
            $data = Supplier::with([
                'kota'
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
            $data['kode'] = $this->kode();
            $store = Supplier::create($data);
            return commit_helper($store);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $store = Supplier::find($data['supplier_id']);
            $store->update($data);
            return commit_helper($store->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function softDestroy($id)
    {
        \DB::beginTransaction();
        try {
            $data = Supplier::destroy($id);
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
