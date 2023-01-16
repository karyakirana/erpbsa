<?php

namespace App\Models\Penjualan;

use App\Models\Master\Customer;
use App\Models\Master\KodeTrait;
use App\Models\Master\Pegawai;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use HasFactory, KodeTrait, SoftDeletes;
    protected $table = 'penjualan';
    protected $fillable = [
        'active_cash',
        'kode',
        'penjualan_penawaran_id',
        'draft',
        'status',
        'tipe_penjualan',
        'tgl_penjualan',
        'tempo',
        'tgl_tempo',
        'customer_id',
        'sales_id',
        'user_id',
        'total_barang',
        'ppn',
        'biaya_lain',
        'total_bayar',
        'keterangan',
    ];

    public function penjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sales()
    {
        return $this->belongsTo(Pegawai::class, 'sales_id');
    }
}
