<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentPiutangPenjualanDetail extends Model
{
    use HasFactory;
    protected $table = 'erpbsa_keuangan.detail_payment_piutang_penjualan';
    protected $fillable = [
        'payment_piutang_penjualan_id',
        'piutang_penjualan_id',
        'tagihan',
        'terbayar',
        'status_bayar'
    ];

    public function paymentPiutangPenjualan(): BelongsTo
    {
        return $this->belongsTo(PaymentPiutangPenjualan::class, 'payment_piutang_penjualan_id');
    }

    public function piutangPenjualan(): BelongsTo
    {
        return $this->belongsTo(PiutangPenjualan::class, 'piutang_penjualan_id');
    }
}
