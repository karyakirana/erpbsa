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
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

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
        $data = $request->validate([]);
        $data['kode'] = $this->kode();
        \DB::beginTransaction();
        try {
            $pembelian = Pembelian::create($data);
            $pembelian->pembelianDetail()->createMany($data['data_detail']);
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
            $pembelian = Pembelian::query()
                ->with([]);
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
            ], 403);
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
            $pembelian = Pembelian::find($pembelian_id)
                ->with([
                    'supplier',
                    'users'
                ]);
            return response()->json([
                'status' => true,
                'data' => $pembelian
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
            $pembelian = Pembelian::find($request['pembelian_id']);
            // rollback
            $pembelian->pembelianDetail()->delete();
            // update
            $pembelian->update($data);
            $pembelian->pembelianDetail()->createMany($data['data_detail']);
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
            ], 403);
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
            $query = Pembelian::find($request->pembelian_id);
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
            ], 403);
        }
    }
}
