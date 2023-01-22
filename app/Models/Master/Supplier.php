<?php

namespace App\Models\Master;

use App\Models\Regency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory, KodeTrait;
    protected $table = 'supplier';
    protected $fillable = [
        'kode',
        'nama',
        'telepon',
        'email',
        'npwp',
        'alamat',
        'kota_id',
        'keterangan',
    ];

    public function kota()
    {
        return $this->belongsTo(Regency::class, 'kota_id');
    }
}
