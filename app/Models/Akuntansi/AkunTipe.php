<?php

namespace App\Models\Akuntansi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunTipe extends Model
{
    use HasFactory;
    protected $table = 'erpbsa_keuangan.akun_tipe';
    protected $fillable = [
        'akun_kategori_id',
        'kode',
        'nama',
        'default_field',
        'keterangan'
    ];

    public function akunKategori()
    {
        return $this->belongsTo(AkunKategori::class, 'akun_kategori_id');
    }
}
