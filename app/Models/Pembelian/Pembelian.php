<?php

namespace App\Models\Pembelian;

use App\Models\Master\KodeTrait;
use App\Models\Master\Supplier;
use App\Models\Persediaan\StockMasuk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian extends Model
{
    use HasFactory, KodeTrait, SoftDeletes;
    protected $table = 'pembelian';
    protected $fillable = [
        'active_cash',
        'pembelian_po_id',
        'tgl_pembelian',
        'kode',
        'draft',
        'status',
        'tipe_pembelian',
        'tempo',
        'tgl_tempo',
        'supplier_id',
        'user_id',
        'total_bayar',
        'ppn',
        'biaya_lain',
        'total_barang',
        'keterangan',
    ];

    public function pembelianDetail()
    {
        return $this->hasMany(PembelianDetail::class, 'pembelian_id');
    }

    public function pembelianPo()
    {
        return $this->belongsTo(PembelianPo::class, 'pembelian_po_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stockMasuk()
    {
        return $this->morphMany(StockMasuk::class, 'stockableMasuk', 'stockable_masuk_type', 'stockable_masuk_id');
    }
}
