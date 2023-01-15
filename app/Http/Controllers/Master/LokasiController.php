<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    protected function kode()
    {
        $data = Lokasi::latest('kode')->first();
        if (!$data){
            $num = 1;
        } else {
            $lastNum = (int) $data->last_num_master;
            $num = $lastNum + 1;
        }
        return "L".sprintf("%05s", $num);
    }

    public function getData(Request $request)
    {
        try {
            $query = Lokasi::query();
            if (!is_null($request->search)){
                $query->where('nama', 'like', '%'.$request->search.'%')
                    ->orWhere('keterangan', 'like', '%'.$request->search.'%');
            }
            return response()->json([
                'status' => 200,
                'data' => $query->get()
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function edit($jabatan_id)
    {
        try {
            $query = Lokasi::find($jabatan_id);
            return response()->json([
                'status' => 200,
                'data' => $query
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:50',
            'keterangan' => 'nullable'
        ]);
        $data['kode'] = $this->kode();
        try {
            $query = Lokasi::create($data);
            return response()->json([
                'status' => 200,
                'data' => $query
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'jabatan_id' => 'required',
            'nama' => 'required|max:50',
            'keterangan' => 'nullable'
        ]);

        try {
            $query = Lokasi::find($data->lokasi_id)->update($data);
            return response()->json([
                'status' => 200,
                'data' => $query
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $query = Lokasi::destroy($request->lokasi_id);
            return response()->json([
                'status' => 200,
                'messages' => 'Data sudah di hapus'
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => 403,
                'messages' => $e->getMessage()
            ]);
        }
    }
}
