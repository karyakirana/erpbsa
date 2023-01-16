<?php

namespace App\Models\Stock;

use App\Models\Master\Lokasi;
use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persediaan extends Model
{
    use HasFactory;
    protected $table = 'persediaan';
    protected $fillable = [
        'active_cash',
        'produk_id',
        'lokasi_id',
        'kondisi',
        'batch',
        'expired',
        'harga_beli',
        'stock_awal',
        'stock_masuk',
        'stock_keluar',
        'stock_lost',
        'stock_saldo',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id');
    }
}
