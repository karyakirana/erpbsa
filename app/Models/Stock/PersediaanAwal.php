<?php

namespace App\Models\Stock;

use App\Models\Master\KodeTrait;
use App\Models\Master\Lokasi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersediaanAwal extends Model
{
    use HasFactory, KodeTrait, SoftDeletes;
    protected $table = 'persediaan_awal';
    protected $fillable = [
        'active_cash',
        'kode',
        'draft',
        'kondisi',
        'lokasi_id',
        'user_id',
        'total_barang',
        'total_nominal',
        'keterangan',
    ];

    public function persediaanAwalDetail()
    {
        return $this->hasMany(PersediaanAwalDetail::class, 'persediaan_awal_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
