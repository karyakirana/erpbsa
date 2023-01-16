<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\Pembelian\PembelianPo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PembelianPOController extends Controller
{
    public function kode()
    {
        $query = PembelianPo::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        $num = (int) $query->first()->last_num_trans + 1;
        return sprintf("%04s", $num)."/PO/".date('Y');
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
            'draft' => 'required|boolean',
            'kondisi' => 'required',
            ''
        ]);
        $data['kode'] = $this->kode();
        \DB::beginTransaction();
        try {
            $pembelianPo = PembelianPo::create($data);
            $pembelianPo->pembelianPoDetail()->createMany($data['data_detail']);
            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $pembelianPo->refresh()
            ], 200);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ], 403);
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
            $pembelianPo = PembelianPo::query()
                ->with([]);
            if (!is_null($request->search)){
                $pembelianPo->where('active_cash', session('active_cash'))
                    ->orWhereRelation('supplier', 'nama', 'like', '%'.$request->search.'%')
                    ->orWhereRelation('users', 'name', 'like', '%'.$request->search.'%')
                    ->orWhere('keterangan', 'like', '%'.$request->search.'%');
            }
            return response()->json([
                'status' => true,
                'data' => $pembelianPo->get()
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
            ], 403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $pembelian_po_id
     * @return JsonResponse
     */
    public function edit($pembelian_po_id)
    {
        try {
            $pembelianPo = PembelianPo::find($pembelian_po_id)
                ->with([
                    'supplier',
                    'users'
                ]);
            return response()->json([
                'status' => true,
                'data' => $pembelianPo
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'messages' => $e->getMessage()
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
        $data = $request->validate([]);
        \DB::beginTransaction();
        try {
            $pembelianPo = PembelianPo::find($request['pembelian_po_id']);
            // rollback
            $pembelianPo->pembelianPoDetail()->delete();
            // update
            $pembelianPo->update($data);
            $pembelianPo->pembelianPoDetail()->createMany($data['data_detail']);
            \DB::commit();
            return response()->json([
                'status'=>200,
                'data' => $pembelianPo->refresh()
            ]);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status'=>403,
                'messages' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        \DB::beginTransaction();
        try {
            $query = PembelianPo::find($request->pembelian_po_id);
            $query->pembelianPoDetail()->delete();
            $query->delete();
            \DB::commit();
            return response()->json([
                'status'=>200,
                'messages' => 'Data Sudah di hapus'
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ]);
        }
    }
}
