<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiutangPenjualan extends Model
{
    use HasFactory;
    protected $table = 'mysql_keuangan.piutang_penjualan';
    protected $fillable = [
        'saldo_piutang_id',
        'piutangable_penjualan_id',
        'piutangable_penjualan_type',
        'status',
        'tgl_piutang',
        'tgl_pelunasan',
        'kurang_bayar',
        'keterangan'
    ];

    public function piutangablePenjualan()
    {
        return $this->morphTo(__FUNCTION__, 'piutangable_penjualan_type', 'piutangable_penjualan_id');
    }

    public function saldoPiutang()
    {
        return $this->belongsTo(SaldoPiutangPenjualan::class, 'saldo_piutang_id');
    }
}
