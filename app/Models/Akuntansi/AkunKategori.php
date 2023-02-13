<?php

namespace App\Models\Akuntansi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunKategori extends Model
{
    use HasFactory;
    protected $table = 'erpbsa_keuangan.akun_kategori';
    protected $fillable = [
        'nama', 'kode', 'keterangan'
    ];
}
