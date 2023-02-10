<?php namespace App\ERP\Stock;

use App\Models\Stock\StockKeluar;

class StockKeluarRepository
{
    public function kode($kondisi = "baik")
    {
        $query = StockKeluar::query()
            ->where('active_cash', get_closed_cash())
            ->where('kondisi', $kondisi)
            ->latest('kode');

        $kodeKondisi = ($kondisi == 'baik') ? 'SK' : 'SKR';

        // check last num
        if ($query->doesntExist()){
            return "0001/{$kodeKondisi}/".date('Y');
        }

        $num = (int) $query->first()->last_num_trans + 1;
        return sprintf("%04s", $num)."/{$kodeKondisi}/".date('Y');
    }
}
