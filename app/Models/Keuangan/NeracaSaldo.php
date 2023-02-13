<?php

namespace App\Models\Keuangan;

use App\Models\Akuntansi\Akun;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeracaSaldo extends Model
{
    use HasFactory;
    protected $table = 'erpbsa_keuangan.neraca_saldo';
    protected $fillable = [
        'active_cash',
        'akun_id',
        'debet',
        'kredit'
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }
}
