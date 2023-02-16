<?php namespace App\ERP\Keuangan;

use App\Models\Akuntansi\CoaConfig;

trait CoaTrait
{
    public function getCoaConfig($config)
    {
        return CoaConfig::find($config);
    }
}
