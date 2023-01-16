<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersediaanAwalDetail extends Model
{
    use HasFactory;
    protected $table = 'persediaan_awal_detail';
    protected $fillable = [
        'persediaan_awal_id',
        'persediaan_id',
        'harga_beli',
        'jumlah',
        'sub_total',
    ];

    public function persediaanAwal()
    {
        return $this->belongsTo(PersediaanAwal::class, 'persediaan_awal_id');
    }

    public function persediaan()
    {
        return $this->belongsTo(Persediaan::class, 'persediaan_id');
    }
}
