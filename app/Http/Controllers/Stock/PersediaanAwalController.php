<?php

namespace App\Http\Controllers\Stock;

use App\ERP\Stock\PersediaanRepository;
use App\Http\Controllers\Controller;
use App\Models\Stock\PersediaanAwal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersediaanAwalController extends Controller
{
    protected function kode($kondisi = 'baik')
    {
        $query = PersediaanAwal::query()
            ->where('active_cash', get_closed_cash())
            ->where('kondisi', $kondisi)
            ->latest('kode');

        $kodeKondisi = ($kondisi == 'baik') ? 'PA' : 'PAR';

        // check last num
        if ($query->doesntExist()){
            return "0001/{$kodeKondisi}/".date('Y');
        }

        $num = (int) $query->first()->last_num_trans + 1;
        return sprintf("%04s", $num)."/{$kodeKondisi}/".date('Y');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        \DB::beginTransaction();
        try {
            $data = $request->validate([
                'draft' => 'required|boolean',
                'kondisi' => 'required',
                'tgl_persediaan_awal' => 'required',
                'lokasi_id' => 'required',
                'total_barang' => 'required|numeric',
                'total_nominal' => 'required|numeric',
                'keterangan' => 'nullable',
                'data_detail' => 'array'
            ]);
            $data['kode'] = $this->kode($data['kondisi']);
            $data['active_cash'] = set_closed_cash(auth()->id());
            $data['user_id'] = auth()->id();
            $persediaanAwal = PersediaanAwal::create($data);
            $persediaanAwalDetail = $persediaanAwal->persediaanAwalDetail();
            foreach ($data['data_detail'] as $row) {
                // add persediaan
                $persediaan = (new PersediaanRepository(
                    $row['produk_id'],
                    $data['lokasi_id'],
                    $data['kondisi'],
                    $row['jumlah'],
                    $row['batch'],
                    $row['expired'],
                    $row['harga_beli'],
                    'stock_awal'
                ))->addStockMasuk();
                // create persediaan detail
                $persediaanAwalDetail->create([
                    'persediaan_id' => $persediaan->id,
                    'harga_beli' => $row['harga_beli'],
                    'jumlah' => $row['jumlah'],
                    'sub_total' => $row['sub_total']
                ]);
            }
            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $persediaanAwal
            ], 200);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'data' => $e->getMessage(),
                'ClosedCash' => set_closed_cash(auth()->id())
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        try {
            $persediaanAwal = PersediaanAwal::query()
                ->with([
                    'persediaanAwalDetail',
                    'users',
                    'lokasi',
                    'persediaanAwalDetail.persediaan',
                    'persediaanAwalDetail.persediaan.produk'
                ]);
            if (!is_null($request->search)){
                $persediaanAwal->where('active_cash', get_closed_cash())
                    ->orWhereRelation('lokasi', 'nama', 'like', '%'.$request->search.'%')
                    ->orWhereRelation('users', 'name', 'like', '%'.$request->search.'%')
                    ->orWhere('keterangan', 'like', '%'.$request->search.'%');
            }
            return response()->json([
                'status' => true,
                'data' => $persediaanAwal->get()
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $persediaan_awal_id
     * @return JsonResponse
     */
    public function edit($persediaan_awal_id)
    {
        try {
            $persediaanAwal = PersediaanAwal::
                with([
                    'persediaanAwalDetail',
                    'users',
                    'lokasi',
                    'persediaanAwalDetail.persediaan',
                    'persediaanAwalDetail.persediaan.produk'
                ])
            ->find($persediaan_awal_id);
            return response()->json([
                'status' => true,
                'data' => $persediaanAwal
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'data' => $e
            ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'persediaan_awal_id' => 'required',
            'draft' => 'required|boolean',
            'kondisi' => 'required',
            'tgl_persediaan_awal' => 'required',
            'lokasi_id' => 'required',
            'user_id' => 'required',
            'total_barang' => 'required|numeric',
            'total_nominal' => 'required|numeric',
            'keterangan' => 'nullable'
        ]);
        \DB::beginTransaction();
        try {
            $persediaanAwal = PersediaanAwal::find($data['persediaan_awal_id']);
            // rollback
            foreach ($persediaanAwal->persediaanAwalDetail as $item) {
                PersediaanRepository::rollbackStockMasuk($item->persediaan_id, $item->jumlah, 'stock_awal');
            }
            $persediaanAwal->persediaanAwalDetail()->delete();
            // update
            $persediaanAwal->update($data);
            $persediaanAwalDetail = $persediaanAwal->persediaanAwalDetail();
            foreach ($data['data_detail'] as $row) {
                // add persediaan
                $persediaan = (new PersediaanRepository(
                    $row['produk_id'],
                    $row['lokasi_id'],
                    $row['kondisi'],
                    $row['jumlah'],
                    $row['batch'],
                    $row['expired'],
                    $row['harga_beli'],
                    'stock_awal'
                ))->addStockMasuk();
                // create persediaan detail
                $persediaanAwalDetail->create([
                    'persediaan_id' => $persediaan->id,
                    'harga_beli' => $row['harga_beli'],
                    'jumlah' => $row['jumlah'],
                    'sub_total' => $row['sub_total']
                ]);
            }
            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $persediaanAwal->refresh()
            ], 200);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'data' => $e
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            $query = PersediaanAwal::find($id);
            $query->persediaanAwalDetail()->delete();
            $query->delete();
            \DB::commit();
            return response()->json([
                'status'=>true,
                'messages' => 'Data Sudah di hapus'
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ], 403);
        }
    }
}
