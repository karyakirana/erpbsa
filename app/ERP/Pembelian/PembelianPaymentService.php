<?php namespace App\ERP\Pembelian;

use App\ERP\PaymentInterface;
use App\Models\Keuangan\PaymentHutangPembelian;

class PembelianPaymentService implements PaymentInterface
{
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

    public function store(array $data)
    {
        \DB::beginTransaction();
        try {
            $store = PaymentHutangPembelian::create($data);
            // update status pembelian
            // update status hutang pembelian
            // create jurnal transaksi
            // update neraca saldo
            return commit_helper($store);
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
