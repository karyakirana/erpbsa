<?php

namespace App\Models\Pembelian;

use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianPoDetail extends Model
{
    use HasFactory;
    protected $table = 'pembelian_po_detail';
    protected $fillable = [
        'pembelian_po_id',
        'produk_id',
        'harga_beli',
        'jumlah',
        'diskon',
        'sub_total',
    ];

    public function pembelianPo()
    {
        return $this->belongsTo(PembelianPo::class, 'pembelian_po_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
