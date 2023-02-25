<?php namespace App\ERP\Stock;

use App\ERP\TransactionInterface;

class StockMutasiService implements TransactionInterface
{

    public function kode($kondisi = "baik")
    {
        // TODO: Implement kode() method.
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function getData($active_cash = true)
    {
        // TODO: Implement getData() method.
    }

    public function getWithDeletedData($active_cash = true)
    {
        // TODO: Implement getWithDeletedData() method.
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function restoreDeletedData($id)
    {
        // TODO: Implement restoreDeletedData() method.
    }

    public function forceDestroy($id)
    {
        // TODO: Implement forceDestroy() method.
    }
}
