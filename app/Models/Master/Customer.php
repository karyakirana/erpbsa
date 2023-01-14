<?php

namespace App\Models\Master;

use App\Models\Regency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'customer';
    protected $fillable = [
        'kode',
        'jenis_instansi',
        'nama',
        'telepon',
        'email',
        'npwp',
        'alamat',
        'kota_id',
        'sales_id',
        'diskon',
        'keterangan',
    ];

    public function kota()
    {
        return $this->belongsTo(Regency::class, 'kota_id');
    }

    public function sales()
    {
        return $this->belongsTo(Pegawai::class, 'sales_id');
    }
}
