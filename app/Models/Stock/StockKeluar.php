<?php

namespace App\Models\Stock;

use App\Models\Master\Customer;
use App\Models\Master\Lokasi;
use App\Models\Master\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockKeluar extends Model
{
    use HasFactory;
    protected $table = 'stock_keluar';
    protected $fillable = [
        'active_cash',
        'stockable_keluar_id',
        'stockable_keluar_type',
        'kode',
        'draft',
        'kondisi',
        'status',
        'surat_jalan',
        'tgl_keluar',
        'lokasi_id',
        'supplier_id',
        'customer_id',
        'user_id',
        'total_barang',
        'total_hpp',
        'keterangan'
    ];

    public function stockableKeluar()
    {
        return $this->morphTo(__FUNCTION__, 'stockable_keluar_type', 'stockable_keluar_id');
    }

    public function stockKeluarDetail()
    {
        return $this->hasMany(StockKeluarDetail::class, 'stock_keluar_id');
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
