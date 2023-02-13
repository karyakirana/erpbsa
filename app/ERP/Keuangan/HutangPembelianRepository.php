<?php namespace App\ERP\Keuangan;

use App\Models\Keuangan\HutangPembelian;
use App\Models\Pembelian\Pembelian;

class HutangPembelianRepository
{
    public static function addFromPembelian(Pembelian $pembelian)
    {
        return HutangPembelian::create([
            'saldo_hutang_id' => $pembelian->supplier_id,
            'hutangable_pembelian_id' => $pembelian->id,
            'hutangable_pembelian_type' => $pembelian::class,
            'status' => 'belum',
            'tgl_hutang' => $pembelian->tgl_pembelian,
            'tgl_pelunasan' => null,
            'kurang_bayar' => $pembelian->total_bayar,
            'keterangan' => $pembelian->keterangan
        ]);
    }

    public static function updateFromPembelian(Pembelian $pembelian)
    {
        $hutangPembelian = $pembelian->hutangPembelian()->first();
        $hutangPembelian->update([
            'saldo_hutang_id' => $pembelian->supplier_id,
            'status' => 'belum',
            'tgl_hutang' => $pembelian->tgl_pembelian,
            'tgl_pelunasan' => null,
            'kurang_bayar' => $pembelian->total_bayar,
            'keterangan' => $pembelian->keterangan
        ]);
    }

    public static function addFromRetur()
    {
        //
    }
}
