<?php

namespace App\Models\Persediaan;

use App\Models\Stock\Persediaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMasukDetail extends Model
{
    use HasFactory;
    protected $table = 'stock_masuk_detail';
    protected $fillable = [
        'stock_masuk_id',
        'persediaan_id',
        'harga_beli',
        'kemasan_id',
        'jumlah',
        'sub_total',
    ];

    public function stockMasuk()
    {
        return $this->belongsTo(StockMasuk::class, 'stock_masuk_id');
    }

    public function persediaan()
    {
        return $this->belongsTo(Persediaan::class, 'persediaan_id');
    }
}
