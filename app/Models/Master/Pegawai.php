<?php

namespace App\Models\Master;

use App\Models\Regency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory, KodeTrait;
    protected $table = 'pegawai';
    protected $fillable = [
        'kode',
        'status',
        'nama',
        'gender',
        'telepon',
        'email',
        'npwp',
        'jabatan_id',
        'alamat',
        'kota_id',
        'keterangan',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function kota()
    {
        return $this->belongsTo(Regency::class, 'kota_id');
    }
}
