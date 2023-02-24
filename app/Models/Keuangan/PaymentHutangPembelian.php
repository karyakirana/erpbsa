<?php

namespace App\Models\Keuangan;

use App\Models\Akuntansi\Akun;
use App\Models\Master\Customer;
use App\Models\Master\KodeTrait;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHutangPembelian extends Model
{
    use HasFactory, KodeTrait;
    protected $table = 'erpbsa_keuangan.payment_hutang_pembelian';
    protected $fillable = [
        'active_cash',
        'kode',
        'tgl_payment',
        'customer_id',
        'user_id',
        'akun_payment',
        'total_payment'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_payment');
    }

    public function paymentHutangPembelianDetail()
    {
        return $this->hasMany(PaymentHutangPembelianDetail::class, 'payment_hutang_pembelian_id');
    }
}
