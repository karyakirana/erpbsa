<?php

namespace App\Models\Keuangan;

use App\Models\Master\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoHutangPembelian extends Model
{
    use HasFactory;
    protected $table = 'erpbsa_keuangan.saldo_hutang_pembelian';
    protected $primaryKey = 'supplier_id';
    protected $fillable = [
        'supplier_id',
        'saldo'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
