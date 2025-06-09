<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SiswaModel;
use App\Models\KotaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

use function PHPUnit\Framework\returnSelf;

class SiswaController extends Controller
{
    public function index() {
        $siswa = SiswaModel::all();
        return view('admin.siswa.index', [
            'siswa' => $siswa->load('kota: id_kota, nama_kota')
        ]);
    }

    public function add() {
        $kota = KotaModel::get(['id_kota', 'nama_kota']);
        return view('admin.siswa.add', [
            'kota' => $kota
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'nis' => ['required', 'numeric', 'unique:siswa, nis'],
            'nama_siswa' => ['required', 'string'],
            'tgl_lahir' => ['required', 'date'],
            'id_kota' => ['required'],
            'gender' => ['in:P,L'],
            'alamat' => ['required', 'text']
        ]);

        $addSiswa = SiswaModel::create($request->all());
        if($addSiswa) return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan');
        return redirect()->back()->with('error', 'Siswa gagal ditambahkan');
    }

    public function edit($id_siswa) {
        $siswa = SiswaModel::find($id_siswa);
        $kota = KotaModel::get(['id_kota', 'nama_kota']);
        return view('admin.siswa.edit', [
            'siswa' => $siswa->load('kota'),
            'kota' => $kota
        ]);
    }

    public function update(Request $request, $id_siswa) {
        $request->validate([
            'nis' => ['required', 'numeric', 'unique:siswa, nis'],
            'nama_siswa' => ['required', 'string'],
            'tgl_lahir' => ['required', 'date'],
            'id_kota' => ['required'],
            'gender' => ['in:P,L'],
            'alamat' => ['required', 'text']
        ]);

        $siswa = SiswaModel::find($id_siswa);
        if(!$siswa) return redirect()->back()->with('error', 'Siswa tidak ditemukan');
        $updateSiswa = $siswa->update($request->all());
        if(!$updateSiswa) return redirect()->back()->with('error', 'Data gagal diperbarui');
        return redirect()->route('admin.siswa.index')->with('success', 'Data berhasil diperbarui');
    }

    public function show($id_siswa) {
        $siswa = SiswaModel::select('id_siswa','nis', 'nama_siswa', 'tgl_lahir', 'id_kota', 'gender', 'alamat')->find($id_siswa);
        if(!$siswa) return $this->responseError('Data tidak ditemukan', 404);
        return $this->responseSuccess([
            'siswa' => $siswa->load('kota: id_kota, nama_kota')
        ]);
    }
    
    public function destroy(Request $request) {
        $siswa = SiswaModel::find($request->id_siswa ?? '');
        if(!$siswa) return redirect()->back()->with('error', 'Siswa tidak ditemukan');
        $siswa->delete();
        return redirect()->back()->with('success', 'Siswa berhasil dihapus');
    }
}
