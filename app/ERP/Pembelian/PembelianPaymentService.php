<?php namespace App\ERP\Pembelian;

use App\ERP\PaymentInterface;
use App\Models\Keuangan\PaymentHutangPembelian;

class PembelianPaymentService implements PaymentInterface
{
    /**
     * pembelian payment :
     * 1. menyimpan pembayaran atas single atau multi nota pembelian
     * 2. bisa dibayar sebagian dan keseluruhan atas nota pembelian
     * 3. Jurnal debet pada hutang pembelian
     * 4. Jurnal kredit pada kas atau setara kas
     * 5. Mengubah status pembelian dan hutang pembelian menjadi terbayar (lunas atau sebagian)
     */

    private $akun_hutang_pembelian;
    private $field_akun_hutang_pembelian;
    private $akun_setara_kas;
    private $field_setara_kas;

    private function kode()
    {
        return NULL;
    }

    public function getData()
    {
        \DB::beginTransaction();
        try {
            $data = PaymentHutangPembelian::where('active_cash', get_closed_cash())
                ->with([
                    'customer',
                    'users',
                    'akun'
                ])->get();
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getById($id)
    {
        \DB::beginTransaction();
        try {
            $data = PaymentHutangPembelian::where('active_cash', get_closed_cash())
                ->with([
                    'customer',
                    'users',
                    'akun'
                ])->find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    private function loadCoaConfig()
    {
        //
    }

    private function keuanganProses()
    {
        //
    }

    private function rollbackKeuangan()
    {
        //
    }

    public function store(array $data)
    {
        \DB::beginTransaction();
        try {
            $data['kode'] = $this->kode();
            $paymentHutangPembelian = PaymentHutangPembelian::create($data);
            // store detail
            $detail = $paymentHutangPembelian->paymentHutangPembelianDetail();
            foreach ($data['paymentHutangPembelianDetail'] as $row) {
                // store detail
                $paymentDetail = $detail->create($row);
                // update penjualan status
                // update hutang status
            }
            // update status pembelian
            // update status hutang pembelian
            // create jurnal transaksi
            // update neraca saldo
            return commit_helper($paymentHutangPembelian->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $payment = PaymentHutangPembelian::find($data['payment_hutang_pembelian_id']);
            // rollback
            $payment->update($data);
            // update status pembelian
            // update status hutang pembelian
            // create jurnal transaksi
            // update neraca saldo
            return commit_helper($payment->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function forceDestroy($id)
    {
        // TODO: Implement forceDestroy() method.
    }
}
