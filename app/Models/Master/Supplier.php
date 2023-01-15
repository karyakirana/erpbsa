<?php

namespace App\Models\Master;

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
}
