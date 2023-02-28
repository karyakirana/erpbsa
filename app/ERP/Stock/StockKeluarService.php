<?php namespace App\ERP\Stock;

use App\ERP\TransactionInterface;
use App\Models\Stock\StockKeluar;

class StockKeluarService implements TransactionInterface
{
    private $akun_hpp;
    private $field_hpp;
    private $akun_persediaan_baik;
    private $field_persediaan_baik;
    private $akun_persediaan_rusak;
    private $field_persediaan_rusak;

    public function kode($kondisi = "baik")
    {
        $query = StockKeluar::query()
            ->where('active_cash', get_closed_cash())
            ->where('kondisi', $kondisi)
            ->latest('kode');

        $kodeKondisi = ($kondisi == 'baik') ? 'SK' : 'SKR';

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
            $stockKeluar = StockKeluar::with([
                'stockableKeluar',
                'stockKeluarDetail',
                'stockKeluarDetail.persediaan',
                'stockKeluarDetail.persediaan.produk',
                'lokasi', 'supplier', 'customer', 'users'
            ])->find($id);
            return commit_helper($stockKeluar);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getData($active_cash = true)
    {
        \DB::beginTransaction();
        try {
            $stockKeluar = StockKeluar::with([
                'stockableKeluar',
                'stockKeluarDetail',
                'stockKeluarDetail.persediaan',
                'stockKeluarDetail.persediaan.produk',
                'lokasi', 'supplier', 'customer', 'users'
            ])->get();
            return commit_helper($stockKeluar);
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
            $stockKeluar = StockKeluar::create($data);
            // update persediaan
            // create stock keluar detail
            // proses keuangan
            return commit_helper($stockKeluar);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $stockKeluar = StockKeluar::find($data['stock_keluar_id']);
            // rollback keuangan
            // rollback persediaan
            // rollback stock keluar detail
            $stockKeluar->update($data);
            // update persediaan
            // create stock keluar detail
            // proses keuangan
            return commit_helper($stockKeluar->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            $stockKeluar = StockKeluar::find($id);
            return commit_helper($stockKeluar->refresh());
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
