<?php namespace App\ERP\Master;

use App\Models\Master\ProdukKategori;

class ProdukKategoriService implements MasterInterface
{
    public function kode()
    {
        $kategori  = new ProdukKategori();
        return master_kode_helper($kategori, 'K');
    }

    public function getDataById($id)
    {
        \DB::beginTransaction();
        try {
            $data = ProdukKategori::find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getData()
    {
        \DB::beginTransaction();
        try {
            $data = ProdukKategori::all();
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
            $store = ProdukKategori::create($data);
            return commit_helper($store);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $store = ProdukKategori::find($data['produk_kategori_id']);
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
            $data = ProdukKategori::destroy($id);
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
