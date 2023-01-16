<?php

namespace App\Http\Controllers\Stock;

use App\ERP\Stock\PersediaanRepository;
use App\Http\Controllers\Controller;
use App\Models\Stock\PersediaanAwal;
use Illuminate\Http\Request;

class PersediaanAwalController extends Controller
{
    protected function kode($kondisi = 'baik')
    {
        $query = PersediaanAwal::query()
            ->where('active_cash', session('ClosedCash'))
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([]);
        $data['kode'] = $this->kode($data['kondisi']);
        \DB::beginTransaction();
        try {
            $persediaanAwal = PersediaanAwal::create($data);
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
                'status' => 200,
                'data' => $persediaanAwal->refresh()
            ]);
        } catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'status' => 500,
                'data' => $e
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
