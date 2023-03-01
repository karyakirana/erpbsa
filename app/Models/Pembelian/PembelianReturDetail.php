<?php

namespace App\Models\Pembelian;

use App\Models\Stock\Persediaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianReturDetail extends Model
{
    use HasFactory;
    protected $table = 'pembelian_retur_detail';
    protected $fillable = [
        'pembelian_retur_id',
        'persediaan_id',
        'harga_jual',
        'jumlah',
        'satuan_jual',
        'diskon',
        'sub_total',
    ];

    public function pembelianRetur()
    {
        return $this->belongsTo(PembelianRetur::class, 'pembelian_retur_id');
    }

    public function persediaan()
    {
        return $this->belongsTo(Persediaan::class, 'persediaan_id');
    }
}
