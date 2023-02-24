<?php

namespace App\Models\Keuangan;

use App\Models\Master\Customer;
use App\Models\Master\KodeTrait;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentPiutangPenjualan extends Model
{
    use HasFactory, KodeTrait;
    protected $table = 'erpbsa_keuangan.payment_piutang_penjualan';
    protected $fillable = [
        'active_cash',
        'kode',
        'tgl_payment',
        'customer_id',
        'user_id',
        'akun_payment',
        'total_payment'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paymentPiutangPenjualanDetail(): HasMany
    {
        return $this->hasMany(PaymentPiutangPenjualanDetail::class, 'payment_piutang_penjualan_id');
    }
}
