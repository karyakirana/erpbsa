<?php

namespace App\Models\Pembelian;

use App\Models\Master\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianRetur extends Model
{
    use HasFactory;
    protected $table = 'pembelian_retur';
    protected $fillable = [
        'active_cash',
        'kode',
        'pembelian_id',
        'status',
        'tgl_retur',
        'supplier_id',
        'user_id',
        'total_barang',
        'ppn',
        'biaya_lain',
        'total_bayar',
        'keterangan',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembelianReturDetail()
    {
        return $this->hasMany(PembelianReturDetail::class, 'pembelian_retur_id');
    }
}
