<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KotaModel;
use Illuminate\Routing\RedirectController;
use Illuminate\Support\Facades\Auth;

class KotaController extends Controller
{
    public function index() {
        $kota = KotaModel::all();
        return view('admin.kota.index', [
            'kota' => $kota
        ]);
    }

    public function add() {
        return view('admin.kota.add');
    }

    public function store(Request $request) {
        $request->validate([
            'nama_kota' => ['required', 'string']
        ]);

        $addKota = KotaModel::create([
            'nama_kota' =>$request->nama_kota,
        ]);
        if(!$addKota) return redirect()->back()->with('error', 'Kota gagal ditambahkan');
        return redirect()->route('admin.kota.index')->with('success', 'Kota berhasil ditambahkan');
    }

    public function edit($id_kota) {
        $kota = KotaModel::find($id_kota);
        if(!$kota) return abort(404);
        return view('admin.kota.edit', [
            'kota' => $kota
        ]);
    }

    public function update(Request $request, $id_kota) {
        $request->validate([
            'nama_kota' => ['required', 'string']
        ]);
        $kota = KotaModel::find($id_kota);
        if(!$kota) return redirect()->back()->with('error', 'Data gagal diperbarui');
        $kota->update([
            'nama_kota' => $request->nama_kota,
        ]);
        return redirect()->route('admin.kota.index')->with('success', 'Data berhasil diperbarui');
    }

    public function show($id_kota) {
        $kota = KotaModel::select('id_kota', 'nama_kota')->get();
        if(!$kota) return $this->responseError('Data tidak ditemukan', 404);
        return $this->responseSuccess([
            'kota' => $kota
        ]);
    }

    public function destroy(Request $request) {
        $kota = KotaModel::find($request->id_kota);
        if(!$kota) return redirect()->back()->with('error', 'Data tidak ditemukan');
        $kota->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
