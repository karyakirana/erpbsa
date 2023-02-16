<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoPiutangPenjualan extends Model
{
    use HasFactory;
    protected $table = 'mysql_keuangan.saldo_piutang_penjualan';
    protected $fillable = [
        'customer_id',
        'saldo',
    ];
}
