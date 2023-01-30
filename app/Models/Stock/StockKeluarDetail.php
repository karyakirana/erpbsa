<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockKeluarDetail extends Model
{
    use HasFactory;
    protected $table = 'stock_keluar_detail';
    protected $fillable = [
        'stock_keluar_id',
        'persediaan_id',
        'harga_beli',
        'jumlah',
        'sub_total'
    ];

    public function stockKeluar()
    {
        return $this->belongsTo(StockKeluar::class, 'stock_keluar_id');
    }

    public function persediaan()
    {
        return $this->belongsTo(Persediaan::class, 'persediaan_id');
    }
}
