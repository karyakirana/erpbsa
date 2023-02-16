<?php

namespace App\Models\Akuntansi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoaConfig extends Model
{
    use HasFactory;
    protected $table = 'erpbsa_keuangan.coa_config';
    protected $primaryKey = 'config';
    protected $keyType = 'string';
    protected $fillable = [
        'config', 'kategori', 'akun_id', 'default_field','keterangan'
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }
}
