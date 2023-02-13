<?php

namespace App\Models\Akuntansi;

use App\Models\Master\KodeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory, KodeTrait;
    protected $table = 'erpbsa_keuangan.akun';
    protected $fillable = [
        'akun_tipe_id', 'kode', 'nama', 'keterangan'
    ];

    public function akunTipe()
    {
        return $this->belongsTo(AkunTipe::class, 'akun_tipe_id');
    }
}
