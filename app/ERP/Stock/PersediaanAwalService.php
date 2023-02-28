<?php namespace App\ERP\Stock;

use App\ERP\Keuangan\JurnalTransaksiService;
use App\ERP\TransactionInterface;
use App\Models\Akuntansi\CoaConfig;
use App\Models\Stock\PersediaanAwal;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PersediaanAwalService implements TransactionInterface
{
    private $akun_persediaan_awal;
    private $field_persediaan_awal;
    private $akun_modal;
    private $field_modal;

    public function kode($kondisi = "baik")
    {
        $persediaan_awal = new PersediaanAwal();
        return trans_kode_helper($persediaan_awal, 'PA', $kondisi);
    }

    public function getById($id)
    {
        \DB::beginTransaction();
        try {
            $data = PersediaanAwal::with([
                'lokasi',
                'users',
                'persediaanAwalDetail',
                'persediaanAwalDetail.persediaan',
                'persediaanAwalDetail.persediaan.produk'
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
            $data = PersediaanAwal::with([
                'lokasi',
                'users',
                'persediaanAwalDetail',
                'persediaanAwalDetail.persediaan',
                'persediaanAwalDetail.persediaan.produk'
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

    private function detail(PersediaanAwal $persediaan_awal, $data)
    {
        foreach ($data['persediaan_awal_detail_store'] as $row){
            // store persediaan
            $persediaan = (new PersediaanRepository(
                $row['produk_id'],
                $persediaan_awal->lokasi_id,
                $persediaan_awal->kondisi,
                $row['jumlah'],
                $row['batch'],
                $row['expired'],
                $row['serial_number'],
                $row['harga'],
                'stock_awal',
                get_closed_cash()
            ))->addStockMasuk();
            $persediaan_awal->persediaanAwalDetail()->create([
                'persediaan_id' => $persediaan->id,
                'harga_beli' => $persediaan->harga_beli,
                'jumlah' => $row['jumlah'],
                'sub_total' => $row['sub_total']
            ]);
        }
    }

    private function loadCoaConfig()
    {
        $coa_persediaan_awal = CoaConfig::find('akun_persediaan_awal');
        if (is_null($coa_persediaan_awal)){
            throw new ModelNotFoundException("Config COA Persediaan Awal Tidak Ada");
        }
        $this->akun_persediaan_awal = $coa_persediaan_awal->akun_id;
        $this->field_persediaan_awal = $coa_persediaan_awal->default_field;
        $coa_modal = CoaConfig::find('akun_modal');
        if (is_null($coa_modal)){
            throw new ModelNotFoundException("Config COA Modal Tidak Ada");
        }
        $this->akun_modal = $coa_modal->akun_id;
        $this->field_modal = $coa_modal->default_field;
    }

    private function keuanganProses(PersediaanAwal $persediaan_awal)
    {
        /** load coa config : persediaan awal dan modal */
        $this->loadCoaConfig();
        /** jurnal transaksi debet */
        JurnalTransaksiService::jurnalWithNeracaAwalDebet(
            $persediaan_awal->jurnal(),
            $this->akun_persediaan_awal,
            $persediaan_awal->total_nominal,
            $this->field_persediaan_awal
        );
        /** jurnal transaksi kredit */
        JurnalTransaksiService::jurnalWithNeracaAwalKredit(
            $persediaan_awal->jurnal(),
            $this->akun_modal,
            $persediaan_awal->total_nominal,
            $this->field_modal
        );
    }

    private function rollbackKeuangan(PersediaanAwal $persediaan_awal)
    {
        /** load coa config */
        $this->loadCoaConfig();
        /** Jurnal Transaksi dan Neraca Saldo rollback */
        JurnalTransaksiService::jurnalWithNeracaAwalRollback($persediaan_awal, $this->field_persediaan_awal, $this->field_modal);
    }

    public function store(array $data)
    {
        \DB::beginTransaction();
        try {
            $data['kode'] = $this->kode($data['kondisi']);
            $data['active_cash'] = get_closed_cash();
            $data['draft'] = false;
            $data['user_id'] = auth()->id();
            $persediaan_awal = PersediaanAwal::create($data);
            // store persediaan detail
            $this->detail($persediaan_awal, $data);
            // keuangan : jurnal transaksi, neraca saldo awal, neraca saldo
            //$this->keuanganProses($persediaan_awal);
            return commit_helper($persediaan_awal->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $persediaan_awal = PersediaanAwal::find($data['persediaan_awal_id']);
            // rollback
            /** rollback keuangan */
            $this->rollbackKeuangan($persediaan_awal);
            /** rollback persediaan awal detail dan persediaan */
            foreach ($persediaan_awal->persediaanAwalDetail as $row){
                PersediaanRepository::rollbackStockMasuk($row->persediaan_id, $row->jumlah, 'stock_awal');
            }
            $persediaan_awal->persediaanAwalDetail()->delete();
            /** update */
            $data['draft'] = false;
            $data['user_id'] = auth()->id();
            $persediaan_awal->update($data);
            // store persediaan detail
            $this->detail($persediaan_awal, $data);
            // keuangan : jurnal transaksi, neraca saldo awal, neraca saldo
            // $this->keuanganProses($persediaan_awal);
            return commit_helper($persediaan_awal->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            $persediaan_awal = PersediaanAwal::find($id);
            /** rollback keuangan */
            // $this->rollbackKeuangan($persediaan_awal);
            /** rollback persediaan awal detail dan persediaan */
            foreach ($persediaan_awal->persediaanAwalDetail as $row){
                PersediaanRepository::rollbackStockMasuk($row->persediaan_id, $row->jumlah, 'stock_awal');
            }
            $persediaan_awal->persediaanAwalDetail()->delete();
            $persediaan_awal->delete();
            return commit_helper($persediaan_awal);
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
