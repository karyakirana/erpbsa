<?php

namespace App\Models\Keuangan;

use App\Models\Akuntansi\Akun;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalTransaksi extends Model
{
    use HasFactory;
    protected $table = 'erpbsa_keuangan.jurnal_transaksi';
    protected $fillable = [
        'active_cash',
        'jurnalable_transaksi_id',
        'jurnalable_transaksi_type',
        'akun_id',
        'debet',
        'kredit'
    ];

    public function jurnalableTransaksi()
    {
        return $this->morphTo(__FUNCTION__, 'jurnalable_transaksi_type', 'jurnalable_transaksi_id');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }
}
