<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukKemasanBeli extends Model
{
    use HasFactory;
    protected $table = 'produk_kemasan_beli';
    protected $fillable = [
        'produk_id',
        'satuan_beli',
        'isi',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
