<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function kode()
    {
        $query = Pegawai::latest('kode')->first();
        if (!$query){
            $num = 1;
        } else {
            $lastNum = (int) $query->last_num_master;
            $num = $lastNum + 1;
        }
        return "E".sprintf("%05s", $num);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:50',
            'gender' => 'required|max:10',
            'telepon' => 'required|max:20',
            'email' => 'required|email|max:20',
            'npwp' => 'nullable|max:20',
            'jabatan_id' => 'required',
            'alamat' => 'required',
            'kota_id' => 'required',
            'keterangan' => 'nullable'
        ]);
        $data['kode'] = $this->kode();
        $data['status'] = 'active';
        try {
            $query = Pegawai::create($data);
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

    public function view(Request $request)
    {
        try {
            $query = Pegawai::query();
            if (!is_null($request->search)){
                $query->where('nama', 'like', '%'.$request->search.'%')
                    ->orWhereRelation('jabatan', 'nama', 'like', '%'.$request->search.'%')
                    ->orWhere('telepon', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%')
                    ->orWhere('alamat', 'like', '%'.$request->search.'%')
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

    public function edit($pegawai_id)
    {
        try {
            $jabatan = Pegawai::find($pegawai_id);
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
            'pegawai_id' => 'required',
            'nama' => 'required|max:50',
            'gender' => 'required|max:10',
            'telepon' => 'required|max:20',
            'email' => 'required|email|max:20',
            'npwp' => 'nullable|max:20',
            'jabatan_id' => 'required',
            'alamat' => 'required',
            'kota_id' => 'required',
            'keterangan' => 'nullable'
        ]);

        try {
            $query = Pegawai::find($data['pegawai_id'])->update($data);
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
            $query = Pegawai::destroy($request->pegawai_id);
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
