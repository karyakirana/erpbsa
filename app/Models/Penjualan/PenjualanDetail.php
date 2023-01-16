<?php

namespace App\Models\Penjualan;

use App\Models\Stock\Persediaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;
    protected $table = 'penjualan_detail';
    protected $fillable = [
        'penjualan_id',
        'persediaan_id',
        'harga_jual',
        'jumlah',
        'satuan_jual',
        'diskon',
        'sub_total',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    public function persediaan()
    {
        return $this->belongsTo(Persediaan::class, 'persediaan_id');
    }
}
