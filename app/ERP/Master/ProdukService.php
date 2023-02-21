<?php namespace App\ERP\Master;

use App\Models\Master\Produk;
use App\Models\Master\ProdukKemasanBeli;

class ProdukService implements MasterInterface
{
    public function kode()
    {
        $produk = new Produk();
        return master_kode_helper($produk, 'P');
    }

    public function getDataById($id)
    {
        \DB::beginTransaction();
        try {
            $data = Produk::with([
                'produkKategori', 'produkImage', 'produkKemasan'
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
            $data = Produk::with([
                'produkKategori', 'produkImage', 'produkKemasan'
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
            $data['status'] = 'active';
            $produk = Produk::create($data);
            if (array_count_values($data['produk_kemasan_beli']) > 0 ){
                //$produk->produkKemasan()->create($data['produk_kemasan_beli']);
            }
            if (array_count_values($data['produk_image']) > 0){
                //$produk->produkImage()->create($data['produk_image']);
            }
            return commit_helper($produk);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $produk = Produk::find($data['produk_id']);
            $produk->produkKemasan()->delete();
            $produk->produkImage()->delete();
            $produk->update($data);
            if (!is_null($data['produk_kemasan_beli'])){
                // $produk->produkKemasan()->create($data['produk_kemasan_beli']);
            }
            if (!is_null($data['produk_image'])){
                // $produk->produkImage()->create($data['produk_image']);
            }
            return commit_helper($produk->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function softDestroy($id)
    {
        \DB::beginTransaction();
        try {
            $data = Produk::destroy($id);
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
