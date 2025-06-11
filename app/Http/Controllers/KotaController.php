<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KotaModel;
use Illuminate\Support\Facades\Validator;

class KotaController extends Controller
{
    public function index() {
        $kota = KotaModel::all(['id_kota', 'nama_kota']);
        return $this->responseSuccess([
            'kota' => $kota
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_kota' => ['required', 'string']
        ]);
        if($validator->fails()) return $this->responseError($validator->errors()->first());
        $validatedData = $validator->valid();
        $kota = KotaModel::create($validatedData);
        if(!$kota) return $this->responseError('Data gagal ditambahkan');
        return $this->responseSuccess('Data berhasil ditambahkan');

    }

    public function update(Request $request, $id_kota) {
        $validator = Validator::make($request->all(), [
            'nama_kota' => ['required', 'string']
        ]);
        if($validator->fails()) return $this->responseError($validator->errors()->first());
        $kota = KotaModel::find($id_kota);
        if(!$kota) return $this->responseError('Data tidak ditemukan');
        $validatedData = $validator->valid();
        $update = $kota->update($validatedData);
        if(!$update) return $this->responseError('Data gagal diperbarui');
        return $this->responseSuccess('Data berhasil diperbarui');

    }

    public function show($id_kota) {
        $kota = KotaModel::find($id_kota);
        if(!$kota) return $this->responseError('Data tidak ditemukan');
        return $this->responseSuccess($kota->only(['nama_kota']));
    }

    public function destroy($id_kota) {
        $kota = KotaModel::find($id_kota);
        if(!$kota) return $this->responseError('Data tidak ditemukan');
        $destroy = $kota->delete();
        if(!$destroy) return $this->responseError('Data gagal dihapus');
        return $this->responseSuccess('Data berhasil dihapus');
    }
}
