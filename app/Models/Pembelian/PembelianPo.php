<?php

namespace App\Models\Pembelian;

use App\Models\Master\KodeTrait;
use App\Models\Master\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembelianPo extends Model
{
    use HasFactory, SoftDeletes, KodeTrait;
    protected $table = 'pembelian_po';
    protected $fillable = [
        'active_cash',
        'kode',
        'draft',
        'status',
        'tgl_pembelian_po',
        'durasi_po',
        'tgl_kadaluarsa_po',
        'supplier_id',
        'user_id',
        'total_barang',
        'ppn',
        'biaya_lain',
        'total_bayar',
        'keterangan',
    ];

    public function pembelianPoDetail()
    {
        return $this->hasMany(PembelianPoDetail::class, 'pembelian_po_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
