<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory, KodeTrait;
    protected $table = 'jabatan';
    protected $fillable = [
        'kode',
        'nama',
        'keterangan',
    ];
}
