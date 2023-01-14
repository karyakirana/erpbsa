<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCn extends Model
{
    use HasFactory;
    protected $table = 'customer_cn';
    protected $fillable = [
        'kode',
        'status',
        'customer_id',
        'penerima',
        'keterangan',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
