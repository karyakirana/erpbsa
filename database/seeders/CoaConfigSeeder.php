<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoaConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('erpbsa_keuangan.coa_config')
            ->insertOrIgnore([
                // pembelian
                ['config'=>'pembelian', 'kategori'=>'pembelian'],
                ['config'=>'pembelian_retur', 'kategori'=>'pembelian'],
                ['config'=>'biaya_pembelian', 'kategori'=>'pembelian'],
                ['config'=>'hutang_pembelian', 'kategori'=>'pembelian'],
                ['config'=>'ppn_pembelian', 'kategori'=>'pembelian'],
                // penjualan
                ['config'=>'penjualan', 'kategori'=>'penjualan'],
                ['config'=>'penjualan_retur', 'kategori'=>'penjualan'],
                ['config'=>'biaya_penjualan', 'kategori'=>'penjualan'],
                ['config'=>'piutang_penjualan', 'kategori'=>'penjualan'],
                ['config'=>'ppn_penjualan', 'kategori'=>'penjualan'],
                // persediaan
                ['config'=>'persediaan_baik', 'kategori'=>'persediaan'],
                ['config'=>'persediaan_rusak', 'kategori'=>'persediaan'],
                ['config'=>'akun_persediaan_awal', 'kategori'=>'persediaan_awal'],
                // modal
                ['config'=>'modal', 'kategori'=>'modal'],
                // periodical account
                ['config'=>'hpp', 'kategori'=>'hpp'],
            ]);
    }
}
