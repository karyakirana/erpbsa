<?php namespace App\ERP;

interface PaymentInterface
{
    public function getData();

    public function getById($id);

    public function store(array $data);

    public function update(array $data);

    public function destroy($id);

    public function forceDestroy($id);
}
