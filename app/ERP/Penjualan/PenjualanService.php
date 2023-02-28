<?php namespace App\ERP\Penjualan;

use App\ERP\Keuangan\JurnalTransaksiService;
use App\ERP\Keuangan\SaldoPiutangPenjualanRepo;
use App\ERP\TransactionInterface;
use App\Models\Akuntansi\CoaConfig;
use App\Models\Penjualan\Penjualan;
use App\Models\Stock\Persediaan;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PenjualanService implements TransactionInterface
{
    private $akun_penjualan;
    private $field_akun_penjualan;
    private $akun_piutang_penjualan;
    private $field_piutang_penjualan;
    public function kode($kondisi = "baik")
    {
        $penjualan = new Penjualan();
        return trans_kode_helper($penjualan, 'PJ');
    }

    public function getById($id)
    {
        \DB::beginTransaction();
        try {
            $data = Penjualan::with([
                'customer',
                'sales',
                'users',
                'penjualanDetail',
                'penjualanDetail.persediaan.produk'
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
            $data = Penjualan::with([
                'customer',
                'sales',
                'users',
                'penjualanDetail',
                'penjualanDetail.persediaan.produk'
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

    private function loadCoaConfig()
    {
        $coa_penjualan = CoaConfig::find('akun_penjualan');
        if (is_null($coa_penjualan)){
            throw new ModelNotFoundException("Config COA Akun Penjualan Tidak Ada");
        }
        $this->akun_penjualan = $coa_penjualan->akun_id;
        $this->field_akun_penjualan = $coa_penjualan->default_field;
        $coa_piutang = CoaConfig::find('akun_piutang_penjualan');
        if (is_null($coa_piutang)){
            throw new ModelNotFoundException("Config COA Akun Piutang Penjualan Tidak Ada");
        }
        $this->akun_piutang_penjualan = $coa_penjualan->akun_id;
        $this->field_piutang_penjualan = $coa_penjualan->default_field;
    }

    private function keuanganProses(Penjualan $penjualan)
    {
        /** piutang penjualan */
        $penjualan->piutangPenjualan()->create([
            'saldo_piutang_id' => $penjualan->customer_id,
            'status' => 'belum',
            'tgl_piutang' => $penjualan->tgl_penjualan,
            'tgl_pelunasan' => NULL,
            'keterangan' => $penjualan->keterangan
        ]);
        /** nambah saldo piutang by customer id */
        (new SaldoPiutangPenjualanRepo($penjualan->customer_id, $penjualan->total_bayar))->increment();
        /** load config coa : penjualan dan piutang penjualan */
        $this->loadCoaConfig();
        /** jurnal transaksi debet */
        JurnalTransaksiService::jurnalDebet(
            $penjualan->jurnal(),
            $this->akun_piutang_penjualan,
            $penjualan->total_bayar,
            $this->field_piutang_penjualan
        );
        /** jurnal transaksi kredit */
        JurnalTransaksiService::jurnalKredit(
            $penjualan->jurnal(),
            $this->akun_penjualan,
            $penjualan->total_bayar,
            $this->field_akun_penjualan
        );
    }

    private function rollbackKeuangan(Penjualan $penjualan)
    {
        /** load config */
        $this->loadCoaConfig();
        /** rollback piutang penjualan */
        $penjualan->piutangPenjualan()->delete();
        /** rollback saldo piutang penjualan */
        (new SaldoPiutangPenjualanRepo($penjualan->customer_id, $penjualan->total_bayar))->decrement();
        /** jurnal transaksi dan neraca saldo rollback */
        JurnalTransaksiService::jurnalWithNeracaAwalRollback($penjualan, $this->field_piutang_penjualan, $this->field_akun_penjualan);
    }

    public function store(array $data)
    {
        \DB::beginTransaction();
        try {
            $data['kode'] = $this->kode();
            $data['active_cash'] = get_closed_cash();
            $data['draft'] = false;
            $data['user_id'] = auth()->id();
            $penjualan = Penjualan::create($data);
            $penjualan->penjualanDetail($data['penjualan_detail_store']);
            // keuangan proses : jurnal transaksi, neraca saldo
            // $this->keuanganProses($penjualan);
            return commit_helper($penjualan->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $penjualan = Penjualan::find($data['penjualan_id']);
            // rollback
            /** rollback keuangan */
            $this->rollbackKeuangan($penjualan);
            /** rollback penjualan detail */
            $penjualan->penjualanDetail()->delete();
            /** update */
            $penjualan->update($data);
            $penjualan->penjualanDetail($data['penjualan_detail_store']);
            // keuangan proses : jurnal transaksi, neraca saldo
            // $this->keuanganProses($penjualan);
            return commit_helper($penjualan->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            $penjualan = Penjualan::find($id);
            /** rollback keuangan */
            $this->rollbackKeuangan($penjualan);
            /** rollback penjualan detail */
            $penjualan->penjualanDetail()->delete();
            $penjualan = $penjualan->delete();
            return commit_helper($penjualan);
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
