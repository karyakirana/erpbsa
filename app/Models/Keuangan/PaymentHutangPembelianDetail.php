<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHutangPembelianDetail extends Model
{
    use HasFactory;
    protected $table = 'erpbsa_keuangan.detail_payment_hutang_pembelian';
    protected $fillable = [
        'payment_hutang_pembelian_id',
        'hutang_pembelian_id',
        'tagihan',
        'terbayar',
        'status_bayar'
    ];

    public function paymentHutangPembelian()
    {
        return $this->belongsTo(PaymentHutangPembelian::class, 'payment_hutang_pembelian_id');
    }

    public function hutangPembelian()
    {
        return $this->belongsTo(HutangPembelian::class, 'hutang_pembelian_id');
    }
}
