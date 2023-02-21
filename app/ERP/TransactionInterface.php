<?php namespace App\ERP;

interface TransactionInterface
{
    public function kode($kondisi = "baik");
    public function getById($id);
    public function getData($active_cash = true);

    public function getWithDeletedData($active_cash = true);

    public function store(array $data);

    public function update(array $data);

    public function destroy($id);

    public function restoreDeletedData($id);

    public function forceDestroy($id);
}
