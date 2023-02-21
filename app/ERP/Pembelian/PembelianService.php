<?php namespace App\ERP\Pembelian;

use App\ERP\TransactionInterface;
use App\Models\Akuntansi\CoaConfig;
use App\Models\Pembelian\Pembelian;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PembelianService implements TransactionInterface
{
    private $akun_pembelian;
    private $field_pembelian;
    private $akun_hutang_pembelian;
    private $field_hutang_pembelian;
    public function kode($kondisi = "baik")
    {
        $pembelian = new Pembelian();
        return trans_kode_helper($pembelian, 'PB');
    }

    public function getById($id)
    {
        \DB::beginTransaction();
        try {
            $data = Pembelian::with([
                'supplier',
                'users',
                'pembelianDetail',
                'pembelianDetail.produk'
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
            $data = Pembelian::with([
                'supplier',
                'users',
                'pembelianDetail',
                'pembelianDetail.produk'
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
        $coaPembelian = CoaConfig::find('akun_pembelian');
        if (is_null($coaPembelian)){
            throw new ModelNotFoundException("Config COA Akun Pembelian Tidak Ada");
        }
        $this->akun_pembelian = $coaPembelian->akun_id;
        $this->field_pembelian = $coaPembelian->default_field;
        $coaHutang = CoaConfig::find('akun_hutang_pembelian');
        if (is_null($coaHutang)){
            throw new ModelNotFoundException("Config COA Akun Hutang Pembelian Tidak Ada");
        }
        $this->akun_hutang_pembelian = $coaHutang->akun_id;
        $this->field_hutang_pembelian = $coaHutang->default_field;
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
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
