<?php

namespace App\Models\Penjualan;

use App\Models\Master\Customer;
use App\Models\Master\Pegawai;
use App\Models\Persediaan\StockMasuk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanRetur extends Model
{
    use HasFactory;
    protected $table = 'penjualan_retur';
    protected $fillable = [
        'active_cash',
        'kode',
        'penjualan_id',
        'status',
        'tgl_retur',
        'customer_id',
        'sales_id',
        'user_id',
        'total_barang',
        'ppn',
        'biaya_lain',
        'total_bayar',
        'keterangan',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function sales()
    {
        return $this->belongsTo(Pegawai::class, 'sales_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stockMasuk()
    {
        return $this->morphOne(StockMasuk::class, 'stockableMasuk', 'stockable_masuk_type', 'stockable_masuk_id');
    }

    public function penjualanRetuerDetail()
    {
        return $this->hasMany(PenjualanReturDetail::class, 'penjualan_retur_id');
    }
}
