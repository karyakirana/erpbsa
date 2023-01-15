<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes, KodeTrait;
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
}
