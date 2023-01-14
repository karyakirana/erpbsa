<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukKategori extends Model
{
    use HasFactory;
    protected $table = 'produk_kategori';
    protected $fillable = [
        'kode',
        'nama',
        'keterangan',
    ];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'produk_kategori_id');
    }
}
