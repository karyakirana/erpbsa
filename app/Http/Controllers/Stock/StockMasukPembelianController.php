<?php

namespace App\Http\Controllers\Stock;

use App\ERP\Stock\PersediaanRepository;
use App\ERP\Stock\StockMasukRepository;
use App\Http\Controllers\Controller;
use App\Models\Pembelian\Pembelian;
use App\Models\Persediaan\StockMasuk;
use Illuminate\Http\Request;

class StockMasukPembelianController extends Controller
{
    public function edit($id)
    {
        try {
            $data = StockMasuk::with([
                'stockableMasuk', 'stockMasukDetail', 'stockMasukDetail.persediaan', 'stockMasukDetail.persediaan.produk'
            ])->find($id);
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } catch (\Exception$e){
            return response()->json([
                'status'=>false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->validate([
                'pembelian_id' => 'required',
                'draft'=>'required',
                'kondisi'=>'required',
                'status'=>'required',
                'surat_jalan'=>'nullable',
                'tgl_masuk' => 'required',
                'lokasi_id' => 'required',
                'supplier_id' => 'required',
                'customer_id'=> 'nullable',
                'keterangan'=> 'required',
                'data_detail' => 'required|array'
            ]);
            $data['active_cash'] = get_closed_cash();
            $data['stockable_masuk_id'] = $data['pembelian_id'];
            $data['stockable_masuk_type'] = Pembelian::class;
            $data['kode'] = (new StockMasukRepository())->kode();
            $data['user_id'] = \Auth::id();
            // hitung total barang
            $datadetail = $data['data_detail'];
            $data['total_barang'] = array_sum(array_column($datadetail, 'jumlah'));
            $data['total_hpp'] = array_sum(array_column($datadetail, 'sub_total'));
            $stockmasuk = StockMasuk::create($data);
            // persediaan bertambah
            foreach ($datadetail as $row){
                // add persediaan
                $persediaan = (new PersediaanRepository(
                    $row['produk_id'],
                    $data['lokasi_id'],
                    $data['kondisi'],
                    $row['jumlah'],
                    $row['batch'],
                    $row['expired'],
                    $row['harga_beli'],
                    'stock_masuk'
                ))->addStockMasuk();
                // create persediaan detail
                $stockmasuk->create([
                    'persediaan_id' => $persediaan->id,
                    'harga_beli' => $row['harga_beli'],
                    'jumlah' => $row['jumlah'],
                    'sub_total' => $row['sub_total']
                ]);
            }
            // hitung total hpp (nominal)
            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $stockmasuk->refresh()
            ], 200);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status'=>false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function show()
    {
        \DB::beginTransaction();
        try {
            $stockMasuk = StockMasuk::query()
                ->with([
                    'users',
                    'supplier',
                    'stockMasukDetail',
                    'stockMasukDetail.persediaan',
                    'stockMasukDetail.persediaan.produk',
                ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $stockMasuk->get()
            ], 200);
        }catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }
}
