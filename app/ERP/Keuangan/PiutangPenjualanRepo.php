<?php namespace App\ERP\Keuangan;

use App\Models\Keuangan\PiutangPenjualan;
use App\Models\Penjualan\Penjualan;

class PiutangPenjualanRepo
{
    public static function addFromPenjualan(Penjualan $penjualan)
    {
        return PiutangPenjualan::create([
            'saldo_piutang_id' => $penjualan->customer_id,
            'piutangable_penjualan_id' => $penjualan->id,
            'piutangable_penjualan_type' => $penjualan::class,
            'status' => 'belum',
            'tgl_piutang' => $penjualan->tgl_penjualan,
            'tgl_pelunasan' => null,
            'kurang_bayar' => $penjualan->total_bayar,
            'keterangan' => $penjualan->keterangan
        ]);
    }

    public static function updateFromPenjualan(Penjualan $penjualan)
    {
        $piutangPenjualan = $penjualan->piutangPenjualan()->first();
        return $piutangPenjualan->update([
            'saldo_piutang_id' => $penjualan->customer_id,
            'piutangable_penjualan_id' => $penjualan->id,
            'piutangable_penjualan_type' => $penjualan::class,
            'status' => 'belum',
            'tgl_piutang' => $penjualan->tgl_penjualan,
            'tgl_pelunasan' => null,
            'kurang_bayar' => $penjualan->total_bayar,
            'keterangan' => $penjualan->keterangan
        ]);
    }
}
