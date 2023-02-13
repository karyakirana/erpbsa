<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HutangPembelian extends Model
{
    use HasFactory;
    protected $table = 'erpbsa_keuangan.hutang_pembelian';
    protected $fillable = [
        'saldo_hutang_id',
        'hutangable_pembelian_id',
        'hutangable_pembelian_type',
        'status',
        'tgl_hutang',
        'tgl_pelunasan',
        'keterangan'
    ];

    public function hutangablePembelian()
    {
        return $this->morphTo(__FUNCTION__, 'hutangable_pembelian_type', 'hutangable_pembelian_id');
    }

    public function saldoHutang()
    {
        return $this->belongsTo(SaldoHutangPembelian::class, 'saldo_hutang_id');
    }
}
