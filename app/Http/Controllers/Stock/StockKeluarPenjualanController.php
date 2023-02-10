<?php

namespace App\Http\Controllers\Stock;

use App\ERP\Stock\PersediaanRepository;
use App\ERP\Stock\StockKeluarRepository;
use App\Http\Controllers\Controller;
use App\Models\Penjualan\Penjualan;
use App\Models\Stock\StockKeluar;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class StockKeluarPenjualanController extends Controller
{
    public function index()
    {
        \DB::beginTransaction();
        try {
            $stockKeluar = StockKeluar::query()
                ->with([
                    'users',
                    'customer',
                    'stockKeluarDetail',
                    'stockKeluarDetail.persediaan',
                    'stockKeluarDetail.persediaan.produk',
                ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $stockKeluar->get()
            ]);
        }catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->validate([
                'penjualan_id' => 'required',
                'draft' => 'required',
                'kondisi' => 'required',
                'status' => 'required',
                'surat_jalan' => 'nullable',
                'tgl_keluar' => 'required',
                'lokasi_id' => 'required',
                'supplier_id' => 'nullable',
                'customer_id' => 'required',
                'keteragan' => 'nullable',

                // stock keluar detail validate
                'stock_keluar_detail' => 'required|array'
            ]);
            $data['active_cash'] = get_closed_cash();
            $data['stockable_keluar_id'] = $data['penjualan_id'];
            $data['stockable_keluar_type'] = Penjualan::class;
            $data['kode'] = (new StockKeluarRepository())->kode();
            $data['user_id'] = \Auth::id();
            // hitung total barang
            $stock_keluar_detail = $data['stock_keluar_detail'];
            $data['total_barang'] = array_sum(array_column($stock_keluar_detail, 'jumlah'));
            $data['total_hpp'] = array_sum(array_column($stock_keluar_detail, 'sub_total'));
            $stockKeluar = StockKeluar::create($data);
            // persediaan bertambah
            foreach ($stock_keluar_detail as $row){
                // mengurangi persediaan
                PersediaanRepository::addStaticStockKeluar(
                    $row['persediaan_id'],
                    $row['jumlah'],
                    "stock_keluar"
                );
                // create stock keluar detail
                $stockKeluar->stockKeluarDetail()->create([
                    'persediaan_id' => $row['persediaan_id'],
                    'harga_beli' => $row['harga_beli'],
                    'jumlah' => $row['jumlah'],
                    'sub_total' => $row['sub_total']
                ]);
            }
            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $stockKeluar->refresh()
            ]);
        } catch (Exception $e){
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        try {
            $data = StockKeluar::with([
                'stockableKeluar', 'stockKeluarDetail',
                'stockKeluarDetail.persediaan', 'stockKeluarDetail.persediaan.produk'
            ])->find($id);
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->validate([
                'stock_keluar_id' => 'required',
                'penjualan_id' => 'required',
                'draft' => 'required',
                'kondisi' => 'required',
                'status' => 'required',
                'surat_jalan' => 'nullable',
                'tgl_keluar' => 'required',
                'lokasi_id' => 'required',
                'supplier_id' => 'nullable',
                'customer_id' => 'required',
                'keteragan' => 'nullable',
            ]);
            $data['user_id'] = \Auth::id();
            // hitung total barang
            $stock_keluar_detail = $data['stock_keluar_detail'];
            $data['total_barang'] = array_sum(array_column($stock_keluar_detail, 'jumlah'));
            $data['total_hpp'] = array_sum(array_column($stock_keluar_detail, 'sub_total'));
            $stockKeluar = StockKeluar::find($data['stock_keluar_id']);
            // rollback
            // rollback persediaan
            $oldDetail = $stockKeluar->stockKeluarDetail;
            foreach ($oldDetail as $item){
                PersediaanRepository::rollbackStockKeluar($item->persediaan_id, $item->jumlah, 'stock_keluar');
            }
            $stockKeluar->stockKeluarDetail()->delete();
            // create
            $stockKeluar->update($data);
            // persediaan bertambah
            foreach ($stock_keluar_detail as $row){
                // mengurangi persediaan
                PersediaanRepository::addStaticStockKeluar(
                    $row['persediaan_id'],
                    $row['jumlah'],
                    "stock_keluar"
                );
                // create stock keluar detail
                $stockKeluar->stockKeluarDetail()->create([
                    'persediaan_id' => $row['persediaan_id'],
                    'harga_beli' => $row['harga_beli'],
                    'jumlah' => $row['jumlah'],
                    'sub_total' => $row['sub_total']
                ]);
            }
            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $stockKeluar->refresh()
            ]);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $stockKeluar = StockKeluar::find($id);
        // rollback
        $stockKeluarDetail = $stockKeluar->stockKeluarDetail;
        foreach ($stockKeluarDetail as $row){
            PersediaanRepository::rollbackStockKeluar($row->persediaan_id, $row->jumlah, 'stock_keluar');
        }
        // delete stock keluar detail
        $stockKeluar->stockKeluarDetail()->delete();
        return $stockKeluar->delete();
    }
}
