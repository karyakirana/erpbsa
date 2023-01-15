<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory, KodeTrait;
    protected $table = 'lokasi';
    protected $fillable = [
        'kode',
        'nama',
        'keterangan',
    ];
}
