<?php

namespace App\Models\Persediaan;

use App\Models\Master\Customer;
use App\Models\Master\Lokasi;
use App\Models\Master\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMasuk extends Model
{
    use HasFactory;
    protected $table = 'stock_masuk';
    protected $fillable = [
        'active_cash',
        'stockable_masuk_id',
        'stockable_masuk_type',
        'kode',
        'draft',
        'kondisi',
        'status',
        'surat_jalan',
        'tgl_masuk',
        'lokasi_id',
        'supplier_id',
        'customer_id',
        'user_id',
        'total_barang',
        'total_hpp',
        'keterangan',
    ];

    public function stockMasukDetail()
    {
        return $this->hasMany(StockMasukDetail::class, 'stock_masuk_id');
    }

    public function stockableMasuk()
    {
        return $this->morphTo(__FUNCTION__, 'stockable_masuk_type', 'stockable_masuk_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
