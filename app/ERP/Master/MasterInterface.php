<?php namespace App\ERP\Master;

interface MasterInterface
{
    public function kode();
    public function getDataById($id);
    public function getData();
    public function getDataIncludeDestroy($active_cash = true);
    public function store(array $data);
    public function update(array $data);
    public function softDestroy($id);
    public function restoreDestroy($id);
    public function destroy($id);
}
