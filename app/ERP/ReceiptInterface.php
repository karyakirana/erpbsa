<?php namespace App\ERP;

interface ReceiptInterface
{
    public function dotMatrix($id);

    public function pdf($id);
}
