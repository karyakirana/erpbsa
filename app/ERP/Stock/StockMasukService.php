<?php namespace App\ERP\Stock;

use App\ERP\TransactionInterface;
use App\Models\Persediaan\StockMasuk;

class StockMasukService implements TransactionInterface
{
    private $akun_hpp;
    private $field_hpp;
    private $akun_persediaan_baik;
    private $field_persediaan_baik;
    private $akun_persediaan_rusak;
    private $field_persediaan_rusak;

    private function kode($kondisi = "baik")
    {
        $query = StockMasuk::query()
            ->where('active_cash', get_closed_cash())
            ->where('kondisi', $kondisi)
            ->latest('kode');

        $kodeKondisi = ($kondisi == 'baik') ? 'SM' : 'SMR';

        // check last num
        if ($query->doesntExist()){
            return "0001/{$kodeKondisi}/".date('Y');
        }

        $num = (int) $query->first()->last_num_trans + 1;
        return sprintf("%04s", $num)."/{$kodeKondisi}/".date('Y');
    }

    public function getById($id)
    {
        \DB::beginTransaction();
        try {
            $data = StockMasuk::with([
                'stockableMasuk',
                'stockMasukDetail',
                'stockMasukDetail.persediaan',
                'stockMasukDetail.persediaan.produk',
                'supplier', 'customer',
                'users'
            ])->find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getData($active_cash = true)
    {
        \DB::beginTransaction();
        try {
            $data = StockMasuk::with([
                'stockableMasuk',
                'stockMasukDetail',
                'stockMasukDetail.persediaan',
                'stockMasukDetail.persediaan.produk',
                'supplier', 'customer',
                'users'
            ])->get();
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
            $data['kode'] = $this->kode($data['kondisi']);
            $stockMasuk = StockMasuk::create($data);
            // stock masuk detail
            // add persediaan
            // add jurnal transaksi stock
            return commit_helper($stockMasuk->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $stockMasuk = StockMasuk::find($data['stock_masuk_id']);
            // rollback persediaan
            // rollback stock masuk detail
            // rollback bagian keuangan
            $stockMasuk->update($data);
            // stock masuk detail
            // add persediaan
            // add jurnal transaksi stock
            return commit_helper($stockMasuk);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            //
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
