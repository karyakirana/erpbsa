<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\Penjualan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    protected function kode()
    {
        $query = Penjualan::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        $num = (int) $query->first()->last_num_trans + 1;
        return sprintf("%04s", $num)."/PJ/".date('Y');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([]);
        $data['kode'] = $this->kode();
        $data['active_cash'] = session('ClosedCash');
        \DB::beginTransaction();
        try {
            $penjualan = Penjualan::create($data);
            $penjualan->penjualanDetail()->createMany($data['data_detail']);
            \DB::commit();
            return response()->json([
                'status'=> true,
                'data' => $penjualan->refresh()
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
            $penjualan = Penjualan::query()
                ->with([]);
            if (!is_null($request->search)){
                $penjualan->where('active_cash', session('active_cash'))
                    ->orWhereRelation('customer', 'nama', 'like', '%'.$request->search.'%')
                    ->orWhereRelation('sales', 'nama', 'like', '%'.$request->search.'%')
                    ->orWhereRelation('users', 'name', 'like', '%'.$request->search.'%')
                    ->orWhere('kode', 'like', '%'.$request->search.'%')
                    ->orWhere('keterangan', 'like', '%'.$request->search.'%');
            }
            return response()->json([
                'status' => true,
                'data' => $penjualan->get()
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
     * @param $penjualan_id
     * @return JsonResponse
     */
    public function edit($penjualan_id)
    {
        try {
            $penjualan = Penjualan::find($penjualan_id)
                ->with([
                    'supplier',
                    'users'
                ]);
            return response()->json([
                'status' => true,
                'data' => $penjualan
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
            $penjualan = Penjualan::find($request['penjualan_id']);
            // rollback
            $penjualan->penjualanDetail()->delete();
            // update
            $penjualan->update($data);
            $penjualan->penjualanDetail()->createMany($data['data_detail']);
            \DB::commit();
            return response()->json([
                'status' => true,
                'data' => $penjualan->refresh()
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
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            $query = Penjualan::find($id);
            $query->penjualanDetail()->delete();
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
