<?php namespace App\ERP\Keuangan;

use App\Models\Akuntansi\CoaConfig;

class CoaConfigService
{
    public function getData()
    {
        \DB::beginTransaction();
        try {
            $data = CoaConfig::with([
                'akun'
            ])->get();
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getByConfig($config)
    {
        \DB::beginTransaction();
        try {
            $data = CoaConfig::with([
                'akun'
            ])->find($config);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function updateByConfig(array $data)
    {
        \DB::beginTransaction();
        try{
            $config = CoaConfig::find($data['config']);
            $config->update($data);
            return commit_helper($config->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }
}
