<?php namespace App\ERP\Master;

use App\Models\Master\Pegawai;

class PegawaiService implements MasterInterface
{
    public function kode()
    {
        $pegawai = new Pegawai();
        return master_kode_helper($pegawai, 'P');
    }

    public function getDataById($id)
    {
        \DB::beginTransaction();
        try {
            $data = Pegawai::with([
                'kota', 'jabatan'
            ])->find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getData()
    {
        \DB::beginTransaction();
        try {
            $data = Pegawai::with([
                'kota', 'jabatan'
            ])->get();
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getDataIncludeDestroy($active_cash = true)
    {
        // TODO: Implement getDataIncludeDestroy() method.
    }

    public function store(array $data)
    {
        \DB::beginTransaction();
        try {
            $data['kode'] = $this->kode();
            $data['status'] = 'active';
            $pegawai = Pegawai::create($data);
            return commit_helper($pegawai);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $pegawai = Pegawai::find($data['pegawai_id']);
            $pegawai->update($data);
            return commit_helper($pegawai->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function softDestroy($id)
    {
        \DB::beginTransaction();
        try {
            $pegawai = Pegawai::destroy($id);
            return commit_helper($pegawai);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function restoreDestroy($id)
    {
        // TODO: Implement restoreDestroy() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}
