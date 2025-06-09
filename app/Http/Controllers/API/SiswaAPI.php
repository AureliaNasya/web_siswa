<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SiswaAPI extends Controller
{
    public function index(Request $request) {
        $siswa = SiswaModel::filter($request)->get();
        return $this->responseSuccess([
            'siswa' => $siswa->load('kota:id_kota, nama_kota')
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'nis' => ['required', 'unique:siswa, nis'],
            'nama_siswa' => ['required', 'string'],
            'tgl_lahir' => ['required', 'date'],
            'gender' => ['required', 'in:P,L'],
            'id_kota' => ['required', 'string', 'uuid'],
            'alamat' => ['required', 'text']
        ]);

        if($validator->fails()) return $this->responseError($validator->errors()->first());
        $validatedData = $validator->valid();
        $siswa = SiswaModel::create($validatedData);
        if(!$siswa) return $this->responseError('Siswa gagal ditambahkan');
        return $this->responseSuccess('Siswa berhasil ditambahkan');
    }

    public function update(Request $request, $id_siswa) {
        $validator = Validator::make($request->all(), [
            'nis' => ['required', 'numeric'], Rule::unique('siswa', 'nim')->ignore($id_siswa),
            'nama_siswa' => ['required', 'string'],
            'tgl_lahir' => ['required', 'date'],
            'gender' => ['required', 'in:P,L'],
            'id_kota' => ['required', 'string', 'uuid'],
            'alamat' => ['required', 'text']
        ]);

        if($validator->fails()) return $this->responseError($validator->errors()->first());
        $siswa = SiswaModel::find($id_siswa);
        if(!$siswa) return $this->responseError('Siswa tidak ditemukan');
        $validatedData = $validator->valid();
        $update = $siswa->update($validatedData);
        if(!$update) return $this->responseError('Siswa gagal diperbarui');
        return $this->responseSuccess('Siswa berhasil diperbarui');
    }

    public function show($id_siswa) {
        $siswa = SiswaModel::find($id_siswa);
        return $this->responseSuccess([
            'siswa' => $siswa->load('kota: id_kota, nama_kota')
        ]);
    }

    public function destroy($id_siswa) {
        $siswa = SiswaModel::find($id_siswa);
        if(!$siswa) return $this->responseError('Siswa tidak ditemukan');
        $destroy = $siswa->delete();
        if(!$siswa) return $this->responseError('Siswa gagal dihapus');
        return $this->responseSuccess('Siswa berhasil dihapus');
    }
}
