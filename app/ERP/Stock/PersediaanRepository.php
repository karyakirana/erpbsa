<?php namespace App\ERP\Stock;

use App\Models\Stock\Persediaan;

class PersediaanRepository
{
    protected $active_cash;
    protected $produk_id;
    protected $jumlah;
    protected $lokasi_id;
    protected $kondisi;
    protected $batch;
    protected $expired;
    protected $serial_number;
    protected $harga_beli;
    protected $field;

    public function __construct(
        $produk_id,
        $lokasi_id,
        $kondisi,
        $jumlah,
        $batch,
        $expired,
        $serial_number,
        $harga_beli,
        $field,
        $active_cash = null
    )
    {
        $this->produk_id = $produk_id;
        $this->lokasi_id = $lokasi_id;
        $this->kondisi = $kondisi;
        $this->batch = $batch;
        $this->serial_number = $serial_number;
        $this->expired = $expired;
        $this->harga_beli = $harga_beli;
        $this->jumlah = $jumlah;
        $this->field = $field;
        if (is_null($active_cash)){
            $this->active_cash = set_closed_cash(auth()->id());
        }
    }

    protected function create()
    {
        return Persediaan::create([
            'active_cash' => $this->active_cash,
            'produk_id' => $this->produk_id,
            'lokasi_id' => $this->lokasi_id,
            'kondisi' => $this->kondisi,
            'batch' => $this->batch,
            'serial_number' => $this->serial_number,
            'expired' => $this->expired,
            'harga_beli' => $this->harga_beli,
            $this->field => $this->jumlah,
            'stock_saldo' => ($this->field == 'stock_keluar' || $this->field == 'stock_lost') ? 0 - (int) $this->jumlah : $this->jumlah
        ]);
    }

    protected function query()
    {
        $query = Persediaan::where('active_cash', $this->active_cash)
            ->where('produk_id', $this->produk_id)
            ->where('lokasi_id', $this->lokasi_id)
            ->where('kondisi', $this->kondisi)
            ->where('harga_beli', $this->harga_beli);

        if (!is_null($this->batch)){
            $query = $query->where('batch', $this->batch);
        }

        if (!is_null($this->expired)){
            $query = $query->where('expired', $this->expired);
        }

        if (!is_null($this->serial_number)){
            $query = $query->where('serial_number', $this->serial_number);
        }

        return $query;
    }

    public function addStockMasuk()
    {
        $query = $this->query();
        if ($query->exists()){
            $query->update([
                $this->field => \DB::raw($this->field." + ".$this->jumlah),
                'stock_saldo' => \DB::raw("stock_saldo + ".$this->jumlah),
            ]);
            return $query->refresh();
        }
        return $this->create();
    }

    public function addStockKeluar()
    {
        $query = $this->query();
        if ($query->exists()){
            $query->update([
                $this->field => \DB::raw($this->field." + ".$this->jumlah),
                'stock_saldo' => \DB::raw("stock_saldo - ".$this->jumlah),
            ]);
            return $query->refresh();
        }
        return $this->create();
    }

    public static function addStaticStockKeluar($persediaan_id, $jumlah, $field)
    {
        return Persediaan::find($persediaan_id)
            ->update([
                $field => \DB::raw($field." - ".$jumlah),
                'stock_saldo' => \DB::raw("stock_saldo - ".$jumlah)
            ]);
    }

    public static function rollbackStockMasuk($persediaan_id, $jumlah, $field)
    {
        return Persediaan::find($persediaan_id)
            ->update([
                $field => \DB::raw($field." - ".$jumlah),
                'stock_saldo' => \DB::raw("stock_saldo - ".$jumlah),
            ]);
    }

    public static function rollbackStockKeluar($persediaan_id, $jumlah, $field)
    {
        return Persediaan::find($persediaan_id)
            ->update([
                $field => \DB::raw($field." - ".$jumlah),
                'stock_saldo' => \DB::raw("stock_saldo + ".$jumlah),
            ]);
    }
}
