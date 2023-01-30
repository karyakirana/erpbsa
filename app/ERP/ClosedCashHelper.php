<?php namespace App\ERP;

use App\Models\ClosedCash;

class  ClosedCashHelper
{
    public function ClosedCash($idUser)
    {
        $data = ClosedCash::whereNull('closed')->latest()->first();
        if ($data) {
            // jika null maka buat data
            return $data->active;
        }
        $generateClosedCash = md5(now());
        $isi = [
            'active' => $generateClosedCash,
            'user_id' => $idUser,
        ];
        $createData = ClosedCash::create($isi);
        return $generateClosedCash;

    }
}
