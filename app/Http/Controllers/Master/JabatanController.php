<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    protected function kode()
    {
        $customer = Jabatan::latest('kode')->first();
        if (!$customer){
            $num = 1;
        } else {
            $lastNum = (int) $customer->last_num_master;
            $num = $lastNum + 1;
        }
        return "J".sprintf("%05s", $num);
    }

    public function getData(Request $request)
    {
        try {
            $query = Jabatan::query();
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
            $jabatan = Jabatan::find($jabatan_id);
            return response()->json([
                'status' => 200,
                'data' => $jabatan
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
            $jabatan = Jabatan::create($data);
            return response()->json([
                'status' => 200,
                'data' => $jabatan
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
            $jabatan = Jabatan::find($data['jabatan_id'])->update($data);
            return response()->json([
                'status' => 200,
                'data' => $jabatan
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
            $jabatan = Jabatan::destroy($request->jabatan_id);
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
