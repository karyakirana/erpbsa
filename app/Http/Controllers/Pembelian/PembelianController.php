<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\Pembelian\Pembelian;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function kode()
    {
        $query = Pembelian::query()
            ->where('active_cash', get_closed_cash())
            ->latest('kode');

        // check last num
        if ($query->doesntExist()) {
            return '0001/PB/'. date('Y');
        }

        $num = (int) $query->first()->last_num_trans + 1;
        return sprintf("%04s", $num)."/PB/".date('Y');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'pembelian_po_id' => 'nullable',
            'draft'=>'required|boolean',
            'tipe_pembelian' => 'required',
            'tgl_pembelian' => 'required',
            'tempo' => 'nullable',
            'tgl_tempo' => 'nullable',
            'supplier_id' => 'required',
            'total_barang' => 'required',
            'ppn' => 'nullable',
            'biaya_lain' => 'nullable',
            'total_bayar' => 'required',
            'keterangan' => 'nullable',
            //'data_detail' => 'required|array',
            'pembelian_detail_store' => 'required'
        ]);
        $data['kode'] = $this->kode();
        $data['active_cash'] = set_closed_cash(auth()->id());
        $data['user_id'] = auth()->id();
        $data['status'] = "Belum Bayar";
        \DB::beginTransaction();
        try {
            $pembelian = Pembelian::create($data);
            //$pembelian->pembelianDetail()->createMany($data['data_detail']);

            $pembelian->pembelianDetail()->createMany($data['pembelian_detail_store']);

            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $pembelian->refresh()
            ]);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status'=>false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        try {
            $pembelian = Pembelian::query()
                ->with([
                    'users',
                    'supplier',
                    'pembelianDetail',
                    'pembelianDetail.produk'
                ]);
            if (!is_null($request->search)){
                $pembelian->where('active_cash', session('active_cash'))
                    ->orWhereRelation('supplier', 'nama', 'like', '%'.$request->search.'%')
                    ->orWhereRelation('users', 'name', 'like', '%'.$request->search.'%')
                    ->orWhere('kode', 'like', '%'.$request->search.'%')
                    ->orWhere('keterangan', 'like', '%'.$request->search.'%');
            }
            return response()->json([
                'status' => true,
                'data' => $pembelian->get()
            ], 200);
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
     * @param $pembelian_id
     * @return JsonResponse
     */
    public function edit($pembelian_id)
    {
        try {
            $pembelian = Pembelian::with([
                'users', 'supplier', 'pembelianDetail', 'pembelianDetail.produk'
            ])
                ->find($pembelian_id);
            return response()->json([
                'status' => true,
                'data' => $pembelian
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ]);
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
            'pembelian_id' => 'required',
            'pembelian_po_id' => 'nullable',
            'draft'=>'required|boolean',
            'tipe_pembelian' => 'required',
            'tgl_pembelian' => 'required',
            'tempo' => 'nullable',
            'tgl_tempo' => 'nullable',
            'supplier_id' => 'required',
            'total_barang' => 'required',
            'ppn' => 'nullable',
            'biaya_lain' => 'nullable',
            'total_bayar' => 'required',
            'keterangan' => 'nullable',
            //'data_detail' => 'required|array',
            'pembelian_detail_store' => 'required'
        ]);
        $data['user_id'] = auth()->id();
        \DB::beginTransaction();
        try {
            $pembelian = Pembelian::find($request['pembelian_id']);
            // rollback
            $pembelian->pembelianDetail()->delete();
            // update
            $pembelian->update($data);
            //$pembelian->pembelianDetail()->createMany($data['data_detail']);

            $pembelian->pembelianDetail()->createMany($data['pembelian_detail_store']);

            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $pembelian->refresh()
            ], 200);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status'=>false,
                'messages' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            $query = Pembelian::find($id);
            $query->pembelianDetail()->delete();
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
            ]);
        }
    }
}
