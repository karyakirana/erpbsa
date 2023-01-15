<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory, KodeTrait;
    protected $table = 'produk';
    protected $fillable = [
        'produk_kategori_id',
        'kode',
        'status',
        'nama',
        'tipe',
        'merk',
        'satuan_jual',
        'harga',
        'max_diskon',
        'buffer_stock',
        'minimum_stock',
        'keterangan',
    ];

    public function produkImage()
    {
        return $this->hasMany(ProdukImage::class, 'produk_id');
    }

    public function produkKemasan()
    {
        return $this->hasMany(ProdukKemasanBeli::class, 'produk_id');
    }

    public function produkKategori()
    {
        return $this->belongsTo(ProdukKategori::class, 'produk_kategori_id');
    }
}
