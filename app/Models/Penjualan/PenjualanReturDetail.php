<?php

namespace App\Models\Penjualan;

use App\Models\Stock\Persediaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanReturDetail extends Model
{
    use HasFactory;
    protected $table = 'penjualan_retur_detail';
    protected $fillable = [
        'penjualan_retur_id',
        'persediaan_id',
        'harga_jual',
        'satuan_jual',
        'diskon',
        'sub_total',
    ];

    public function penjualanRetur()
    {
        return $this->belongsTo(PenjualanRetur::class, 'penjualan_retur_id');
    }

    public function persediaan()
    {
        return $this->belongsTo(Persediaan::class, 'persediaan_id');
    }
}
